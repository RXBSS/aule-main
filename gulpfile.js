// Includes
const gulp = require('gulp');
const rename = require("gulp-rename");
const gulpStaticPhp = require('gulp-static-php');
const del = require('del');

/**
 * Hier werden alle Tasks aus der orthor.gulp.js in das Gulp-File geschrieben. 
 * Wenn ein Task angepasst werden soll, dann kann man dies hier tun. 
 * Dazu kann man entweder den Task überschreiben oder mit einer If Abfrage komplett ausblenden
 * 
 * Wichtig ist auch, dass man hier den Namen des Systems angibt. 
 * Dieser wird nämlich für BrowserSync und für die JS Datei übernommen
 * 
 * // Name des System
 * og.system = 'template';
 * 
 * // Optional kann Browsersync überschrieben werden mit 
 * og.browserSyncPath = 'somepath';
 * 
 */

const og = require('./orthor/manual_modules/orthor/orthor.gulp.js');

// Overwrite Defaults 
og.system = 'aule';

for (var item in og) {
    exports[item] = og[item];
}

function copyAdditionalJs() {

    // Src
    var src = [
        './node_modules/@zxing/library/umd/index.js',
        './node_modules/@zxing/library/umd/index.min.js',
        './node_modules/@zxing/library/umd/index.min.js.map',
        './manual_modules/EloixClient-min.js',
        './manual_modules/EloixClient.js'
    ];

    return gulp.src(src)
        .pipe(rename(function (file) {

            file.basename = file.basename.replace(/index/g, "zxing");
        }))
        .pipe(gulp.dest('./dist/js/optionals/'));
};

function createDocu() {

    return gulp.src('dist/api/plugins/artikel-api.php')
        .pipe(gulpStaticPhp())
        .pipe(gulp.dest('docu/'));

}

function clearArchive() {
    return del(['./dist/data/documents/**/*','!./dist/data/documents/templates']);
}





// 
exports.copyAdditionalJs = copyAdditionalJs;
exports.createDocu = createDocu;
exports.clearArchive = clearArchive;

// Multi Task müssen hier definiert werden
exports.copyPageLevel = gulp.task('copyPageLevel', gulp.series(og.copyPageLevelCss, og.copyPageLevelJs, og.copyPageLevelApi));
exports.copyPagesAndPlugins = gulp.task('copyPagesAndPlugins', gulp.series(og.copyPagesAndPluginsRaw, 'copyPageLevel'));
exports.copy = gulp.task('copy', gulp.series(og.clearEnv, og.copyOrthor, gulp.parallel('copyPagesAndPlugins', og.copyStyles, og.copyScripts, og.copyIncludes, og.copyModules, og.copyMisc, og.copyAssets, og.copyApi, copyAdditionalJs)));
exports.watch = gulp.task('watch', gulp.series('copy', og.startWatch));