<template>
    <div class="dashboard-page2 body">
        <div class="wrap">
            <Row>
                <Card style="width:100%">
                    <div style="text-align:center">
                        <Avatar :src="avator" size="large" />
                        <h3>{{ username }}</h3>
                    </div>
                </Card>
            </Row>

            <Row class="m-t-10">
                <Card>
                    <p slot="title">
                        <Icon type="ios-heart"></Icon>
                        {{ __('个人资料') }}
                    </p>
                    <div>
                        <Row>
                            <i-button type="success" long>{{ email }}</i-button> <br /><br />
                            <i-button type="info" long>{{ mobile }}</i-button>
                        </Row>
                    </div>
                </Card>
            </Row>
        </div>
    </div>
</template>

<script src="./asserts/profile.js"></script>
