import * as esbuild from "esbuild";

const watch = process.argv.includes('--watch');

const jsOptions = {
    entryPoints: [
        "assets/js/source/outerwhisper-admin.js",
        "assets/js/source/outerwhisper-form-builder.js",
        "assets/js/source/outerwhisper-form-frontend.js"
    ],
    bundle: true,
    minify: false,
    outdir: "assets/js/dist",
    platform: "browser",
    target: ["es2020"],
    sourcemap: false
};

const cssOptions = {
    entryPoints: [
        "assets/css/source/outerwhisper-admin.css",
        "assets/css/source/outerwhisper-form-builder.css",
        "assets/css/source/outerwhisper-form-frontend.css"
    ],
    bundle: true,
    minify: false,
    outdir: "assets/css/dist",
    target: ["es2020"],
    sourcemap: false
};

if (watch) {
    const ctxJs = await esbuild.context(jsOptions);
    const ctxCss = await esbuild.context(cssOptions);
    await Promise.all([ctxJs.watch(), ctxCss.watch()]);
    console.log("Watch-Modus aktiviert.");
} else {
    await Promise.all([
        esbuild.build(jsOptions),
        esbuild.build(cssOptions)
    ]);
    console.log("Build abgeschlossen.");
}