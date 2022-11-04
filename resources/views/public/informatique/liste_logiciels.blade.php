@extends('layouts.default')

@section('content')

<div class="pre-banniere">
    <div class="banniere">
        <i class="fas fa-angle-double-left" onclick="window.location.href = '{{route('public.informatique.show_demandes') }}'"></i>
        <p class="nomCategorieActuelle">Informatique</p>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8  me-0 me-lg-4 mb-4">

            <div class="row justify-content-center text-center">
                
                <h5 class="fw-bolder">Salles informatiques</h5>

                <div class="bulle mt-3 mb-3">
                    <h5 class="">I01</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">14</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">28</span>
                </div>

                <div class="bulle mt-3 mb-3">
                    <h5 class="">I02</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">18</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">18</span>
                </div>

                <div class="bulle mt-3 mb-3">
                    <h5 class="">TD2</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">21</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">21</span>
                </div>

                <div class="bulle mt-3 mb-3">
                    <h5 class="">TD3</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">18</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">36</span>
                </div>

                <div class="bulle mt-3 mb-3">
                    <h5 class="">TD4</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">21</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">21</span>
                </div>

                <div class="bulle mt-3 mb-4">
                    <h5 class="">P05b</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">14</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">14</span>
                </div>

                <div class="bulle mt-3 mb-4">
                    <h5 class="">P26</h5>

                    <i class="fas fa-desktop"></i>
                    <span class="nb-places">14</span>
                    <br/>
                    <i class="fas fa-chair"></i>
                    <span class="nb-places">28</span>
                </div>

                <hr/>
                
            </div>

            <div class="row justify-content-center si_applications mt-4">
                <div class="col-5 me-0 me-lg-4 mb-3">

                    <h5 class="fw-bolder">Applications locales</h5>
                    
                    <div class="accordion mt-4" id="accordion1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">
                                    Bureautique
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        <div class="col-3 logo-block" >
                                            <img src="../images/logos/Foxit.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Foxit reader"/>
                                        </div>
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/Notepad.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Notepad ++"/>
                                        </div>
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/Office.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Office Pro Word Excel PowerPoint (I01)"/>
                                        </div>
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/LibreOffice.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Libre office"/>
                                        </div>
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/PDFsam.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PDF Sam"/>
                                        </div>
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/7zip.png" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="7zip"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Conception Graphique
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_conceptgraphi = [
                                            ['fichier' => 'Adobe_Illustrator_CS5.png', 'title' => 'Adobe Illustrator CS5 (TD3)'],
                                            ['fichier' => 'Adobe_InDesign_CS5.png', 'title' => 'Adobe InDesign CS5 (TD3)'],
                                            ['fichier' => 'Adobe_Photoshop_CS5.png', 'title' => 'Adobe Photoshop CS5 (TD3)'],
                                            ['fichier' => 'Adobe_Premiere_Pro_CS5.png', 'title' => 'Adobe Premiere Pro CS5 (TD3)'],
                                            ['fichier' => 'Affinity_Designer.png', 'title' => 'Affinity Designer'],
                                            ['fichier' => 'Affinity_Photo.png', 'title' => 'Affinity Photo'],
                                            ['fichier' => 'Affinity_Publisher.png', 'title' => 'Affinity Publisher']
                                        ];
                                        @endphp

                                        @foreach($applications_conceptgraphi as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" aria-expanded="true"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Developpement 
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">

                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'Anaconda.ico', 'title' => 'Anaconda'],
                                            ['fichier' => 'codeblocks.ico', 'title' => 'CodeBlocks'],
                                            ['fichier' => 'CubeIDE.ico', 'title' => 'CudeIDE'],
                                            ['fichier' => 'Eclipse.ico', 'title' => 'Eclipse CPP <br/>Eclipse JAVA<br/>Eclipse JEE<br/>Eclipse Modeling'],
                                            ['fichier' => 'Enterprise_Architect_Sparkx.ico', 'title' => 'Entreprise Architect Sparx'],
                                            ['fichier' => 'Git.ico', 'title' => 'Git'],
                                            ['fichier' => 'Java.ico', 'title' => 'Java JDK && JRE'],
                                            ['fichier' => 'JetBrains_clion.ico', 'title' => 'JetBrains CLion'],
                                            ['fichier' => 'JetBrains_InteliJ.ico', 'title' => 'JetBrains InteliJ IDEA'],
                                            ['fichier' => 'JetBrains_phpstorm.ico', 'title' => 'JetBrains WebStorm'],
                                            ['fichier' => 'JetBrains_webstorm.ico', 'title' => 'JetBrains PhpStorm'],
                                            ['fichier' => 'nodeJS.ico', 'title' => 'Node.js avec Ionic'],
                                            ['fichier' => 'TalendOS_BD.ico', 'title' => 'Talend OpenStudio Big Data'],
                                            ['fichier' => 'TalendOS_DI.ico', 'title' => 'Talend OpenStudio Data Integration'],
                                            ['fichier' => 'TalendOS_DQ.ico', 'title' => 'Talend OpenStudio Data Quality'],
                                            ['fichier' => 'UnrealEngine.ico', 'title' => 'Unreal Engine'],
                                            ['fichier' => 'Unity.ico', 'title' => 'Unity (P26)'],
                                            ['fichier' => 'XCTU.ico', 'title' => 'X-CTU'],
                                            ['fichier' => 'XMLPad.ico', 'title' => 'XmlPad']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach

                                    </div>
                                    <ul>
                                        <li>Android Studio</li>
                                        <li>Arduino IDE</li>
                                        <li>CubeMX</li>
                                        <li>LEGO Mindstorm Education</li>
                                        <li>Mblock</li>
                                        <li>MS Visual Studio Pro</li>
                                        <li>MS VSCode</li>
                                        <li>S4A</li>
                                        <li>Scratch Desktop</li>
                                    </ul>

                                    
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Graphisme / Prototypage 
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_graphproto = [
                                            ['fichier' => 'Balsamiq_Mockups.ico', 'title' => 'Balsamiq Mockups (TD3)'],
                                            ['fichier' => 'gimp.ico', 'title' => 'Gimp'],
                                            ['fichier' => 'snagit.ico', 'title' => 'SnagIt TechSmith (TD3)'],
                                            ['fichier' => 'VISIO.ico', 'title' => 'Microsoft Visio']
                                        ];
                                        @endphp

                                        @foreach($applications_graphproto as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>

                                    <ul>
                                        <li>Blender</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Internet / Multimedia 
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_internet = [
                                            ['fichier' => 'Audacity.ico', 'title' => 'Audacity'],
                                            ['fichier' => 'firefox.ico', 'title' => 'FireFox ESR'],
                                            ['fichier' => 'thunderbird.ico', 'title' => 'Thunderbird'],
                                            ['fichier' => 'VLC.ico', 'title' => 'VLC']
                                        ];
                                        @endphp

                                        @foreach($applications_internet as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Electronique 
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_elec = [
                                            ['fichier' => 'KiCad.ico', 'title' => 'KicaD'],
                                            ['fichier' => 'Labview.ico', 'title' => 'LabWindow<br/>LabWindowCVI<br/>LabView Circuit Design Suite Multisim'],
                                            ['fichier' => 'Memspro.ico', 'title' => 'MEMSPro'],
                                            ['fichier' => 'SignalExpress.ico', 'title' => 'SignalExpress']
                                        ];
                                        @endphp

                                        @foreach($applications_elec as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <ul>
                                        <li>Ultiboard</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Logiciels Scientifiques 
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_logScienti = [
                                            ['fichier' => 'Actran.ico', 'title' => 'Actran VI'],
                                            ['fichier' => '3DSMax.ico', 'title' => 'AutoDesk 3DSMax'],
                                            ['fichier' => 'AutoCAD.ico', 'title' => 'AutoDesk AutoCAD'],
                                            ['fichier' => 'Inventor Pro.ico', 'title' => 'AutoDesk Inventor'],
                                            ['fichier' => 'civa.ico', 'title' => 'Civa'],
                                            ['fichier' => 'Comsol.ico', 'title' => 'Comsol'],
                                            ['fichier' => 'maine3A.ico', 'title' => 'Maine 3A'],
                                            ['fichier' => 'Matlab.ico', 'title' => 'Matlab'],
                                            ['fichier' => 'R.ico', 'title' => 'R'],
                                            ['fichier' => 'R Studio.ico', 'title' => 'Rstudio'],
                                            ['fichier' => 'Simcenter3D.ico', 'title' => 'Simcenter 3D'],
                                            ['fichier' => 'SolidWorks.ico', 'title' => 'SolidWorks']
                                        ];
                                        @endphp

                                        @foreach($applications_logScienti as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <ul>
                                        <li>Decade</li>
                                        <li>Simcenter Test.Lab</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingHeight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHeight" aria-expanded="false" aria-controls="collapseHeight">
                                    Sécurité 
                                </button>
                            </h2>
                            <div id="collapseHeight" class="accordion-collapse collapse" aria-labelledby="headingHeight" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>F-Secure Client Security</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-5 me-0 me-lg-4 mb-3">

                    <h5 class="fw-bolder">Applications réseau</h5>
                    
                    <div class="accordion mt-4" id="accordion2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOnetwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnetwo" aria-expanded="true" aria-controls="collapseOnetwo">
                                    Bureautique
                                </button>
                            </h2>
                            <div id="collapseOnetwo" class="accordion-collapse collapse show" aria-labelledby="headingOnetwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_bureautique = [
                                            ['fichier' => 'Miktek.ico', 'title' => 'MiKTeX'],
                                            ['fichier' => 'Texstudio.ico', 'title' => 'TexStudio']
                                        ];
                                        @endphp

                                        @foreach($applications_bureautique as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwotwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwotwo" aria-expanded="false" aria-controls="collapseTwotwo">
                                    Conception Graphique
                                </button>
                            </h2>
                            <div id="collapseTwotwo" class="accordion-collapse collapse" aria-labelledby="headingTwotwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_bureautique = [
                                            ['fichier' => 'HotPotatoes.ico', 'title' => 'HotPotatoes'],
                                            ['fichier' => 'Scribus.ico', 'title' => 'Scribus']
                                        ];
                                        @endphp

                                        @foreach($applications_bureautique as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThreetwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreetwo" aria-expanded="false" aria-controls="collapseThreetwo">
                                    Developpement 
                                </button>
                            </h2>
                            <div id="collapseThreetwo" class="accordion-collapse collapse" aria-labelledby="headingThreetwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'bouml.ico', 'title' => 'BoUML'],
                                            ['fichier' => 'kompozer.ico', 'title' => 'Kompozer'],
                                            ['fichier' => 'python.ico', 'title' => 'Python'],
                                            ['fichier' => 'Serna XML.ico', 'title' => 'Serna XML'],
                                            ['fichier' => 'TSLite.ico', 'title' => 'TopStyle'],
                                            ['fichier' => 'yEd.ico', 'title' => 'yEd']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFourtwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourtwo" aria-expanded="false" aria-controls="collapseFourtwo">
                                    Graphisme / Prototypage 
                                </button>
                            </h2>
                            <div id="collapseFourtwo" class="accordion-collapse collapse" aria-labelledby="headingFourtwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'dia.ico', 'title' => 'DIA'],
                                            ['fichier' => 'inkscape.ico', 'title' => 'InkScape (Vectoriel)'],
                                            ['fichier' => 'irfanView.ico', 'title' => 'IrfanView & Irfanplugins'],
                                            ['fichier' => 'NetLogo.ico', 'title' => 'NetLogo'],
                                            ['fichier' => 'PhotoFiltre7.ico', 'title' => 'Photo Filtre']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFivetwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFivetwo" aria-expanded="false" aria-controls="collapseFivetwo">
                                    Electronique 
                                </button>
                            </h2>
                            <div id="collapseFivetwo" class="accordion-collapse collapse" aria-labelledby="headingFivetwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Circuit Diagram</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSixtwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixtwo" aria-expanded="false" aria-controls="collapseSixtwo">
                                    Logiciels Scientifiques 
                                </button>
                            </h2>
                            <div id="collapseSixtwo" class="accordion-collapse collapse" aria-labelledby="headingSixtwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'FreeFEM.ico', 'title' => 'FreeFEM++<br/>FreeFEM++ CS'],
                                            ['fichier' => 'optgeo.ico', 'title' => 'OptGeo'],
                                            ['fichier' => 'RDM.ico', 'title' => 'RDM'],
                                            ['fichier' => 'Scilab.ico', 'title' => 'Scilab'],
                                            ['fichier' => 'NetLogo.ico', 'title' => 'NetLogo'],
                                            ['fichier' => 'PhotoFiltre7.ico', 'title' => 'Photo Filtre']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <ul>
                                        <li>Maxima</li>
                                        <li>WxMaxima</li>
                                        <li>Pari GP</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <h5 class="fw-bolder">Applications Linux</h5>
                    
                    <div class="accordion mt-4" id="accordion3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOnethree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnethree" aria-expanded="true" aria-controls="collapseOnetwo">
                                    Bureautique, Editeur, Visionneuse
                                </button>
                            </h2>
                            <div id="collapseOnethree" class="accordion-collapse collapse show" aria-labelledby="headingOnethree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_bureautique = [
                                            ['fichier' => 'nom.ico', 'title' => 'Brasero'],
                                            ['fichier' => 'nom.ico', 'title' => 'Documents'],
                                            ['fichier' => 'nom.ico', 'title' => 'Doxygen'],
                                            ['fichier' => 'nom.ico', 'title' => 'Libre Office'],
                                            ['fichier' => 'nom.ico', 'title' => 'Texlive'],
                                            ['fichier' => 'Texstudio.ico', 'title' => 'TexStudio']
                                        ];
                                        @endphp

                                        @foreach($applications_bureautique as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThreethree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreethree" aria-expanded="false" aria-controls="collapseThreetwo">
                                    Developpement 
                                </button>
                            </h2>
                            <div id="collapseThreethree" class="accordion-collapse collapse" aria-labelledby="headingThreethree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'codeblocks.ico', 'title' => 'CodeBlocks'],
                                            ['fichier' => 'Eclipse.ico', 'title' => 'Eclipse CPP <br/>Eclipse JAVA<br/>Eclipse JEE<br/>Eclipse Modeling'],
                                            ['fichier' => 'nom.ico', 'title' => 'Geany'],
                                            ['fichier' => 'Git.ico', 'title' => 'Git'],
                                            ['fichier' => 'nom.ico', 'title' => 'Gitkraken'],
                                            ['fichier' => 'nom.ico', 'title' => 'G-Prolog'],
                                            ['fichier' => 'nom.ico', 'title' => 'Hadoop'],
                                            ['fichier' => 'nom.ico', 'title' => 'mongoDB'],
                                            ['fichier' => 'nom.ico', 'title' => 'MariaDB client'],
                                            ['fichier' => 'nom.ico', 'title' => 'OpenJDK'],
                                            ['fichier' => 'nom.ico', 'title' => 'Postgesql client'],
                                            ['fichier' => 'nom.ico', 'title' => 'Spyden (python)']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFourthree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourthree" aria-expanded="false" aria-controls="collapseFourtwo">
                                    Graphisme / Prototypage 
                                </button>
                            </h2>
                            <div id="collapseFourthree" class="accordion-collapse collapse" aria-labelledby="headingFourthree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'dia.ico', 'title' => 'DIA'],
                                            ['fichier' => 'inkscape.ico', 'title' => 'InkScape (Vectoriel)'],
                                            ['fichier' => 'irfanView.ico', 'title' => 'IrfanView & Irfanplugins'],
                                            ['fichier' => 'NetLogo.ico', 'title' => 'NetLogo'],
                                            ['fichier' => 'PhotoFiltre7.ico', 'title' => 'Photo Filtre']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFivethree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFivethree" aria-expanded="false" aria-controls="collapseFivetwo">
                                    Internet, Multimédia 
                                </button>
                            </h2>
                            <div id="collapseFivethree" class="accordion-collapse collapse" aria-labelledby="headingFivethree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Circuit Diagram</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSixthree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixthree" aria-expanded="false" aria-controls="collapseSixtwo">
                                    Logiciels Scientifiques 
                                </button>
                            </h2>
                            <div id="collapseSixthree" class="accordion-collapse collapse" aria-labelledby="headingSixthree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center text-center">
                                        @php 
                                        $applications_dev = [
                                            ['fichier' => 'FreeFEM.ico', 'title' => 'FreeFEM++<br/>FreeFEM++ CS'],
                                            ['fichier' => 'optgeo.ico', 'title' => 'OptGeo'],
                                            ['fichier' => 'RDM.ico', 'title' => 'RDM'],
                                            ['fichier' => 'Scilab.ico', 'title' => 'Scilab'],
                                            ['fichier' => 'NetLogo.ico', 'title' => 'NetLogo'],
                                            ['fichier' => 'PhotoFiltre7.ico', 'title' => 'Photo Filtre']
                                        ];
                                        @endphp

                                        @foreach($applications_dev as $appli)
                                        <div class="col-3 logo-block">
                                            <img src="../images/logos/{{$appli['fichier']}}" class="logo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="{{$appli['title']}}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <ul>
                                        <li>Maxima</li>
                                        <li>WxMaxima</li>
                                        <li>Pari GP</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

                
            </div>
        </div>
    </div>
</div>


@endsection