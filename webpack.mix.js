const cssImport = require("postcss-import");
const cssNesting = require("postcss-nesting");
const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

require("laravel-mix-purgecss");

mix
  .js("resources/js/app.js", "public/js")
  .postCss("resources/css/app.css", "public/css", [
    cssImport(),
    cssNesting(),
    tailwindcss("tailwind.config.js")
  ])
  .version();

if (mix.inProduction()) {
  mix.purgeCss();
} else {
  mix.sourceMaps();
}
