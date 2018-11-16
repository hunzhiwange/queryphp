const gulp = require("gulp");
const fs = require("fs");
const path = require("path");
const supportExt = ["js", "vue"];
const tmpDir = "./tmp-i18n/";
const po = require("node-po");
const moment = require("moment");
const i18nSupport = ["en-US", "zh-CN", "zh-TW"];
const i18nFile = ["default"];

// 提取语言包
gulp.task("default", function() {
    if (!fsExistsSync(tmpDir)) {
        fs.mkdir(tmpDir, function(err) {
            if (err) {
                return console.error(err);
            }
        });
    }

    readDir("./src");
});

// po 转换为 JSON
gulp.task("po", function() {
    i18nSupport.forEach(function(i18n) {
        poToJson(i18n);
    });
});

// 修复 iview for prettier
// iview 的 <Button> <Input> 属于 HTML 语言会被格式化为 <button>
// 我们替换 <Button> 为 <i-button> 来避免被破坏
gulp.task("iview", function() {
    readDirIView("./src");
});

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
};

function poToJson(i18n) {
    let items = {};

    i18nFile.forEach(function(poFile) {
        let sourcePoFile = "src/i18n/" + i18n + "/" + poFile + ".po";

        if (!fsExistsSync(sourcePoFile)) {
            return;
        }

        po.load(sourcePoFile, function(_po) {
            _po.items.forEach(function(item) {
                if ("" !== item.msgstr[0]) {
                    items[item.msgid] = item.msgstr[0];
                }
            });

            let result =
                "/* " +
                moment().format("YYYY-MM-DD HH:mm:ss") +
                " */" +
                "\n" +
                "export default " +
                JSON.stringify(items) +
                ";";

            let saveFile = "src/i18n/" + i18n + "/index.js";

            fs.writeFile(saveFile, result, function(err) {
                if (err) {
                    throw err;
                }

                console.log("Saved " + saveFile);
            });
        });
    });
}

function fsExistsSync(path) {
    try {
        fs.accessSync(path, fs.F_OK);
    } catch (e) {
        return false;
    }
    return true;
}

function readDirIView(filePath) {
    fs.readdir(filePath, function(err, files) {
        if (err) {
            console.warn(err);
        } else {
            files.forEach(function(filename) {
                var filedir = path.join(filePath, filename);

                fs.stat(filedir, function(eror, stats) {
                    if (eror) {
                        console.warn(err);
                    } else {
                        var isFile = stats.isFile();
                        var isDir = stats.isDirectory();

                        if (isFile) {
                            var ext = filedir.split(".").pop();
                            if (supportExt.contains(ext)) {

                                fs.readFile(filedir,'utf8',function(err,files){
                                    var result = files.replace(/\<Input(\s){1}/g, '<i-input ');
                                    result = result.replace(/\<\/Input\>/g, '</i-input>');

                                    result = result.replace(/\<Col(\s){1}/g, '<i-col ');
                                    result = result.replace(/\<\/Col\>/g, '</i-col>');
                                    
                                    result = result.replace(/\<Button(\s){1}/g, '<i-button ');
                                    result = result.replace(/\<\/Button\>/g, '</i-button>');

                                    result = result.replace(/\<Form(\s){1}/g, '<i-form ');
                                    result = result.replace(/\<\/Form\>/g, '</i-form>');

                                    result = result.replace(/\<Select(\s){1}/g, '<i-select ');
                                    result = result.replace(/\<\/Select\>/g, '</i-select>');

                                    result = result.replace(/\<Option(\s){1}/g, '<i-option ');
                                    result = result.replace(/\<\/Option\>/g, '</i-option>');

                                    result = result.replace(/\<Progress(\s){1}/g, '<i-progress ');
                                    result = result.replace(/\<\/Progress\>/g, '</i-progress>');

                                    result = result.replace(/\<Menu(\s){1}/g, '<i-menu ');
                                    result = result.replace(/\<\/Menu\>/g, '</i-menu>');
                        
                                    fs.writeFile(filedir, result, 'utf8', function (err) {
                                         if (err) return console.log(err);
                                    });
                                })
                            }
                        }

                        if (isDir) {
                            readDir(filedir);
                        }
                    }
                });
            });
        }
    });
}

function readDir(filePath) {
    fs.readdir(filePath, function(err, files) {
        if (err) {
            console.warn(err);
        } else {
            files.forEach(function(filename) {
                var filedir = path.join(filePath, filename);

                fs.stat(filedir, function(eror, stats) {
                    if (eror) {
                        console.warn(err);
                    } else {
                        var isFile = stats.isFile();
                        var isDir = stats.isDirectory();

                        if (isFile) {
                            var ext = filedir.split(".").pop();
                            if (
                                supportExt.contains(ext) &&
                                -1 === filedir.indexOf(".tmp.i18n.js")
                            ) {
                                readLang(filedir);
                            }
                        }

                        if (isDir) {
                            readDir(filedir);
                        }
                    }
                });
            });
        }
    });
}


function readLang(file) {
    fs.readFile(file, "utf-8", function(error, data) {
        if (error) return console.log("error" + error.message);
        var reg = /__\([\'\"\s](.*?)[\'\"\s]\)/g;
        var result = data.match(reg);

        if (!result) {
            return;
        }

        var tmpFile = file + ".tmp.i18n.js";
        tmpFile = tmpFile.replace(/\//g, "_");

        fs.writeFile(tmpDir + "/" + tmpFile, result.join("\n"), function(err) {
            if (err) {
                throw err;
            }

            console.log("Saved " + tmpFile);
        });
    });
}
