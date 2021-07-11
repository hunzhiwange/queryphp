const gulp = require('gulp')
const fs = require('fs')
const path = require('path')
const supportExt = ['js', 'vue']
const tmpDir = './tmp-i18n/'
const po = require('node-po')
const moment = require('moment')
const i18nSupport = ['en-US', 'zh-CN', 'zh-TW']
const i18nFile = ['default']

// 提取语言包
gulp.task('default', function() {
    if (!fsExistsSync(tmpDir)) {
        fs.mkdir(tmpDir, function(err) {
            if (err) {
                return console.error(err)
            }
        })
    }

    clearDir(tmpDir)
    readDir('./src')
})

// po 转换为 JSON
gulp.task('po', function() {
    i18nSupport.forEach(function(i18n) {
        poToJson(i18n)
    })
})

// 修复 iview for prettier
// iview 的 <Button> <Input> 属于 HTML 语言会被格式化为 <button>
// 我们替换 <Button> 为 <i-button> 来避免被破坏
gulp.task('iview', function() {
    readDirIView('./src')
})

Array.prototype.contains = function(obj) {
    var i = this.length
    while (i--) {
        if (this[i] === obj) {
            return true
        }
    }
    return false
}

function poToJson(i18n) {
    let items = {}

    i18nFile.forEach(function(poFile) {
        let sourcePoFile = 'src/i18n/' + i18n + '/' + poFile + '.po'

        if (!fsExistsSync(sourcePoFile)) {
            return
        }

        po.load(sourcePoFile, function(_po) {
            _po.items.forEach(function(item) {
                if ('' !== item.msgstr[0]) {
                    items[item.msgid] = item.msgstr[0]
                }
            })

            let result =
                '/* ' +
                moment().format('YYYY-MM-DD HH:mm:ss') +
                ' */' +
                '\n' +
                'export default ' +
                JSON.stringify(items) +
                ';'

            let saveFile = 'src/i18n/' + i18n + '/index.js'

            fs.writeFile(saveFile, result, function(err) {
                if (err) {
                    throw err
                }

                console.log('Saved ' + saveFile)
            })
        })
    })
}

function fsExistsSync(path) {
    try {
        fs.accessSync(path, fs.F_OK)
    } catch (e) {
        return false
    }
    return true
}

function firstWordUpperCase(str) {
    return str.toLowerCase().replace(/(\s|^)[a-z]/g, function(char) {
        return char.toUpperCase()
    })
}

function readDirIView(filePath) {
    fs.readdir(filePath, function(err, files) {
        if (err) {
            console.warn(err)
        } else {
            files.forEach(function(filename) {
                var filedir = path.join(filePath, filename)

                fs.stat(filedir, function(eror, stats) {
                    if (eror) {
                        console.warn(err)
                    } else {
                        var isFile = stats.isFile()
                        var isDir = stats.isDirectory()

                        if (isFile) {
                            var ext = filedir.split('.').pop()
                            if (supportExt.contains(ext)) {
                                fs.readFile(filedir, 'utf8', function(err, files) {
                                    var h5Ele = [
                                        'input',
                                        'col',
                                        'button',
                                        'form',
                                        'select',
                                        'option',
                                        'progress',
                                        'menu',
                                        'table',
                                    ]
                                    var result = files

                                    h5Ele.forEach(v => {
                                        var upperV = firstWordUpperCase(v)
                                        result = result.replace(
                                            new RegExp('\\<' + upperV + '(\\s){1}', 'g'),
                                            '<i-' + v + ' '
                                        )
                                        result = result.replace(
                                            new RegExp('\\<\\/' + upperV + '\\>', 'g'),
                                            '</i-' + v + '>'
                                        )
                                    })

                                    fs.writeFile(filedir, result, 'utf8', function(err) {
                                        if (err) return console.log(err)
                                    })
                                })
                            }
                        }

                        if (isDir) {
                            readDirIView(filedir)
                        }
                    }
                })
            })
        }
    })
}

function readDir(filePath) {
    fs.readdir(filePath, function(err, files) {
        if (err) {
            console.warn(err)
        } else {
            files.forEach(function(filename) {
                var filedir = path.join(filePath, filename)

                fs.stat(filedir, function(eror, stats) {
                    if (eror) {
                        console.warn(err)
                    } else {
                        var isFile = stats.isFile()
                        var isDir = stats.isDirectory()

                        if (isFile) {
                            var ext = filedir.split('.').pop()
                            if (supportExt.contains(ext) && -1 === filedir.indexOf('.tmp.i18n.js')) {
                                readLang(filedir)
                            }
                        }

                        if (isDir) {
                            readDir(filedir)
                        }
                    }
                })
            })
        }
    })
}

function readLang(file) {
    fs.readFile(file, 'utf-8', function(error, data) {
        if (error) return console.log('error' + error.message)
        var reg = /__[\s]*\([\s]*[\'\"]+[^\)]+[\'\"]+[\s]*\)/g
        var result = data.match(reg)
        if (!result) {
            return
        }

        var tmpFile = file + '.tmp.i18n.js'
        tmpFile = tmpFile.replace(/\//g, '_')
        fs.writeFile(tmpDir + '/' + tmpFile, result.join('\n'), function(err) {
            if (err) {
                throw err
            }

            console.log('Saved ' + tmpFile)
        })
    })
}

function clearDir(filePath) {
    fs.readdir(filePath, function(err, files) {
        if (err) {
            console.warn(err)
        } else {
            files.forEach(function(filename) {
                var filedir = path.join(filePath, filename)

                fs.stat(filedir, function(eror, stats) {
                    if (eror) {
                        console.warn(err)
                    } else {
                        var isFile = stats.isFile()
                        var isDir = stats.isDirectory()

                        if (isFile) {
                            fs.unlinkSync(filedir)
                            console.log('File `' + filedir + '` has deleted.')
                        }

                        if (isDir) {
                            removeDir(filedir)
                        }
                    }
                })
            })
        }
    })
}
