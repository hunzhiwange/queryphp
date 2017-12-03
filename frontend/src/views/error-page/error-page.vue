
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
                    <span class="publish-button"><Button>预览</Button></span>
                    <span class="publish-button"><Button >保存草稿</Button></span>
                    <span class="publish-button"><Button icon="ios-checkmark" style="width:90px;" type="primary">发布</Button></span>
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
        },
        dragEnd(evt) {

        },
        officeSite() {
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
