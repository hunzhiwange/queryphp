import logo from '@/assets/images/logo.png'

export default {
    methods: {
        officeSite() {
            window.open('http://www.queryphp.com')
        },
        githubSite() {
            window.open('https://github.com/hunzhiwange/queryphp')
        },
        page403() {
            router.replace('/403')
        },
        page404() {
            router.replace('/404')
        },
        page500() {
            router.replace('/500')
        },
    },
    data() {
        return {
            logo: logo,
        }
    },
}
