import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel([
            // "resources/css/tailwind.css", // uncomment to use tailwind css
            "resources/js/app.js",
        ]),
        react(),
        viteStaticCopy({
            targets: [
                {
                    src: "resources/template/",
                    dest: "resources",
                },
            ],
        }),
    ],
    resolve: {
        alias: {
            "~": "node_modules/",
        },
    },
    // server: {  // uncomment if use secure localhost url
    //     https: true,
    //     host: 'localhost',
    // },
});
