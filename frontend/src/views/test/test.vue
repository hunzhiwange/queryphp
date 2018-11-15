<template>
<div>
    <Table :columns="columns1" :data="data1" border id="resizeTable" draggable >
        <div slot="header">dssdfsdf</div>
    </Table>

<table class="hello">
    <thead>
        <tr>
            <th><div class="noCrsr">th 1</div></th>
            <th><div class="noCrsr">th 2</div></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>td 1</td>
            <td>td 2</td>
        </tr>
    </tbody>
</table>

  </div>
</template>
<script>
    export default {
        data () {
            return {
                columns1: [
                    {
                        title: 'Name',
                        key: 'name',

                        // ,
                        renderHeader: (h, params) => {
                            return (
                                <span>
                                    <span>
                                        <span>{params.column.title}</span>

                                    </span>
                                </span>
                                )
                        }
                    },
                    {
                        title: 'Age',
                        key: 'age',
renderHeader: (h, params) => {
                            return (
                                <span>
                                    <span>
                                        <span>{params.column.title}</span>

                                    </span>
                                </span>
                                )
                        }
                    },
                    {
                        title: 'Address',
                       key: 'address',
width: 260
                    }
                ],
                data1: [
                    {
                        name: 'John Brown',
                        age: 18,
                        address: 'New York No. 1 Lake Park',
                        date: '2016-10-03'
                    },
                    {
                        name: 'Jim Green',
                        age: 24,
                        address: 'London No. 1 Lake Park',
                        date: '2016-10-01'
                    },
                    {
                        name: 'Joe Black',
                        age: 30,
                        address: 'Sydney No. 1 Lake Park',
                        date: '2016-10-02'
                    },
                    {
                        name: 'Jon Snow',
                        age: 26,
                        address: 'Ottawa No. 2 Lake Park',
                        date: '2016-10-04'
                    }
                ]
            }
        },
            methods: {

          },
        mounted() {

        }
    }
</script>

<style>
</style>
