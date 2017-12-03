import http from '@/utils/http'

export default {
    data() {
        return {
            dataTree: [
            ],
            buttonProps: {
                type: 'ghost',
                size: 'small'
            }
        }
    },
    methods: {
        renderContent(h, {root, node, data}) {
            return h('span', {
                style: {
                    display: 'inline-block',
                    width: '100%'
                }
            }, [
                h('span', [
                    h('Icon', {
                        props: {
                            type: 'ios-paper-outline'
                        },
                        style: {
                            marginRight: '8px'
                        }
                    }),
                    h('span', data.title)
                ]),
                h('span', {
                    style: {
                        display: 'inline-block',
                        float: 'right',
                        marginRight: '32px'
                    }
                }, [
                    h('Button', {
                        props: Object.assign({}, this.buttonProps, {icon: 'ios-plus-empty'}),
                        style: {
                            marginRight: '8px'
                        },
                        on: {
                            click: () => {
                                this.append(data)
                            }
                        }
                    }),
                    h('Button', {
                        props: Object.assign({}, this.buttonProps, {icon: 'ios-minus-empty'}),
                        on: {
                            click: () => {
                                this.remove(root, node, data)
                            }
                        }
                    })
                ])
            ]);
        },
        append(data) {
            const children = data.children || [];
            children.push({title: 'appended node', expand: true});
            this.$set(data, 'children', children);
        },
        remove(root, node, data) {
            const parentKey = root.find(el => el === node).parent;
            const parent = root.find(el => el.nodeKey === parentKey).node;
            const index = parent.children.indexOf(data);
            parent.children.splice(index, 1);
        },
        init: function() {
            this.apiGet('menu').then((res) => {
                this.handelResponse(res, (data) => {
                    this.dataTree = data.menu
                    // this.status = data.status
                })
            })
        },
    },
    created: function() {
        this.init()
    },
    activated: function() {
        if (_g.needRefresh(this)) {
            this.init()
        }
    },
    mixins: [http]
}
