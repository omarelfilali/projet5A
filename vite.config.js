import laravel from 'laravel-vite-plugin'
import {defineConfig, loadEnv} from 'vite'


export default ({ mode }) => {
    // Load app-level env vars to node-level env vars.
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    return defineConfig({
        server: {
            host: true,
            hmr: {
                // Force the Vite client to connect via SSL
                // This will also force a "https://" URL in the hot file 
                // protocol: 'wss',
                
                // The host where the Vite dev server can be accessed
                // This will also force this host to be written to the hot file
                host: process.env.VITE_URL,
              },
              port: 8080,
        },
        plugins: [
            laravel([
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/css/app.css',
                'resources/css/admin.css',
                
                // CSS des modules
                'resources/css/module_materiel.css',

                // JS des modules
                'resources/js/module_materiel.js',
            ]),
            {
                name: 'blade',
                handleHotUpdate({ file, server }) {
                    if (file.endsWith('.blade.php')) {
                        server.ws.send({
                            type: 'full-reload',
                            path: '*',
                        });
                    }
                },
            }
    
        ],
    });
}
