import {defineConfig} from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        {
            name: 'watch-all-php-files',
            handleHotUpdate({file, server}) {
                if (file.endsWith('.php')) {
                    server.ws.send({type: 'full-reload', path: '*'});
                }
            }
        }
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        allowedHosts: true,
        cors: {
            origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(\.ddev\.site)(?::\d+)?$/,
        },
        hmr: {
            host: process.env.DDEV_HOSTNAME || 'sitela.ddev.site',
            protocol: 'wss',
            clientPort: 5173
        }
    },
    build: {
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: 'src/style.css', 
      output: {
        assetFileNames: 'outputHasil.css', 
      }
    }
  }
});
