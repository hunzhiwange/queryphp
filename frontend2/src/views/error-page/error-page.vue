
<template>
<div class="error-page">
    <Row>
        <Card>
            <p slot="title">
                <Icon :size="14" type="ios-navigate-outline"></Icon>
                <a @click="officeSite">404-{{gettext('前往')}}页面不存在 {{ hello }}</a>
            </p>
            <Row>
                <Col span="10">
                <Card dis-hover>
                    {{gettext('前往')}}
                </Card>
                </Col>
                <Col span="14" class="padding-left-10">
                <Row type="flex" align="middle" class="error-page-intro-con">
r
                    <draggable v-model="tags" :move="dragMove" @update="dragEnd" class="xxx2">
                        <transition-group class="xxx">
                            <div v-for="element in tags" :key="element.id">
                                {{element.name}}
                            </div>
                        </transition-group>
                    </draggable>r

                    <p>当访问的页面不存在时会跳转到404页面，您可以在浏览器地址栏中修改url为一个不存在的路径，体验一下效果</p>
                </Row>
                </Col>
            </Row>
        </Card>
    </Row>
</div>
</template>

<script>
import draggable from 'vuedraggable'
//import queryphp from '@/utils/queryphp'
//var fs2 = require('fs')
//import fs from "fs"
//import path from "path"
//import en from '@/i18n'

//配置远程路径
//var remotePath = "/resource/fd/promote/201507/qixi/";



export default {
    methods: {
        dragMove(evt) {
            console.log(evt.draggedContext.element.id)
        },
        dragEnd(evt) {
            console.log('拖动前的索引 :' + evt.oldIndex)
            console.log('拖动后的索引 :' + evt.newIndex)
            console.log(this.tags)
        },
        officeSite() {

            //console.log(__('共 %d 条',7))

            //console.log(en)
            //alert(queryphp.sprintf('The first 4 letters of the english alphabet are: %s, %s, %s and %s', 'cracker', 'Polly', 'wants', 'wants'))

            //获取当前目录绝对路径，这里resolve()不传入参数
            //let filePath = path.resolve()

            //读取文件存储数组
            //let fileArr = []

            //console.log(filePath)

            // //读取文件目录
            // fs.readdir(filePath,function(err,files){
            //     if(err){
            //         console.log(err);
            //         return;
            //     }
            //     var count = files.length;
            //     //console.log(files);
            //     var results = {};
            //     files.forEach(function(filename){
            //
            //         //filePath+"/"+filename不能用/直接连接，Unix系统是”/“，Windows系统是”\“
            //         fs.stat(path.join(filePath,filename),function(err, stats){
            //             if (err) throw err;
            //             //文件
            //             if(stats.isFile()){
            //                 if(getdir(filename) == 'html'){
            //                     var newUrl=remotePath+filename;
            //                     fileArr.push(newUrl);
            //                     writeFile(fileArr);
            //                 }
            //                 // (getdir(filename) == 'html')&&(fileArr.push(filename);writeFile(newUrl));
            //             //    console.log("%s is file", filename);
            //             }else if(stats.isDirectory()){
            //                 // console.log("%s is a directory文件目录", filename);
            // 　　　　　　　　　//返回指定文件名的扩展名称
            // 　　　　　　　 　//console.log(path.extname("pp/index.html"));
            //
            //                  if(filename == 'css' || filename == 'images'){
            // //var readurl = filePath+'/'+filename;
            //                          //filePath+"/"+filename不能用/直接连接，Unix系统是”/“，Windows系统是”\“
            //                      //    console.log(path.join(filePath,filename));
            //                          var name = filename;
            //                          readFile(path.join(filePath,filename),name);
            //                  }
            //             }
            //         });
            //     });
            // });

        },
        supportSite() {
            window.open('http://www.queryphp.com/support/')
        },
        githubSite() {
            window.open('https://github.com/hunzhiwange/queryphp')
        }
    },
    data() {
        return {
            hello: __('前往'),
            tags: [
                {
                    id: '1',
                    name: '帝国'
                },
                {
                    id: '2',
                    name: '帝国2'
                },
                {
                    id: '3',
                    name: '帝国3'
                },
                {
                    id: '4',
                    name: '帝国4'
                }
            ]
        }
    },
    components: {　　
        draggable
    }
}
</script>
