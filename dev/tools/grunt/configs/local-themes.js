/**
 * grunt exec:AndriiShkrebtii_luma_ru_ru && grunt less:AndriiShkrebtii_luma_ru_ru && grunt watch
 * grunt exec:AndriiShkrebtii_luma_en_us && grunt less:AndriiShkrebtii_luma_en_us && grunt watch
 * Compiles CSS files, Republishes symlinks to the source files commands and stay watch less files.
 */
module.exports = {
    AndriiShkrebtii_luma_ru_ru: {
        area: 'frontend',
        name: 'AndriiShkrebtii/luma',
        locale: 'ru_RU',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    AndriiShkrebtii_luma_en_us: {
        area: 'frontend',
        name: 'AndriiShkrebtii/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
