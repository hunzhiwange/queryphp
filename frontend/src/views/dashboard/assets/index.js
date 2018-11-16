import logo from "@/assets/images/logo.png";

export default {
    methods: {
        officeSite() {
            window.open("http://www.queryphp.com");
        },
        supportSite() {
            window.open("http://www.queryphp.com/support/");
        },
        githubSite() {
            window.open("https://github.com/hunzhiwange/queryphp");
        }
    },
    data() {
        return {
            logo: logo
        };
    }
};
