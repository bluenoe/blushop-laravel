import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0",
        port: 5174,
        strictPort: true,
        hmr: {
            // Bây giờ nó sẽ đọc IP từ file .env, bà không cần sửa ở đây nữa
            host: process.env.VITE_HMR_HOST || "localhost",
            port: 5174,
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
