<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotReturned;
use App\Mail\ToReturnSoon;
use App\Models\InventaireEmprunt;
use Carbon\Carbon;

class MailDelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:maildelay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer des mails par rapport aux dates de fin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Paramétrage des durées
        $remind_before_min_length = 15; // Durée minimale de l'emprunt (en jours) pour laquelle on envoie un rappel avant
        $remind_before_day_nb = 3; // Nombre de jours avant la date de fin d'emprunt auquel on envoie le rappel
        $remind_after_day_nb = 3; // Nombre de jours après que la date de rendu soit dépassée auquel on envoie le second rappel 

        //Envoi des mails avant la date de fin
        $this->info('Envoi des e-mails ('.$remind_before_day_nb.' jours avant)');
        $emp_before = InventaireEmprunt::whereRaw('DATEDIFF(fin_date, debut_date) < ?')
            ->setBindings([$remind_before_min_length])
            ->where('rendu_date', NULL)
            ->where('fin_date', '>', Carbon::now()->subDays(3))
            ->where('sendmailbefore', 0)
            
            ->get();

        foreach($emp_before as $emp) {
            $mail = new ToReturnSoon(route('requests.index'), $emp->id);
            $student = $emp->etudiant;
            Mail::to($student->email, $student->nomprenom)->send($mail);
            $emp->sendmailbefore = 1;
            $emp->save();
        }

        $sent_mails = count($emp_before);
        $this->warn("- $sent_mails e-mail(s) envoyé(s)");

        //Envoi des mails après la date de fin
        $this->info('');
        $this->info('Envoi des e-mails ('.$remind_after_day_nb.' jours après)');
        $emp_after = InventaireEmprunt::where('rendu_date', NULL)
            ->where('fin_date', '>', Carbon::now()->addDays(3))
            ->where('sendmailafter', 0)
            ->get();

        foreach($emp_after as $emp) {
            $mail = new NotReturned(route('requests.index'), $emp->id);
            $student = $emp->etudiant;
            Mail::to($student->email, $student->nomprenom)->send($mail);
            $emp->sendmailafter = 1;
            $emp->save();
        }

        $sent_mails = count($emp_after);
        $this->warn("- $sent_mails e-mail(s) envoyé(s)");

        return Command::SUCCESS;
    }
}
