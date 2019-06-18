// http://eslint.org/docs/user-guide/configuring
// https://www.cnblogs.com/taoshengyijiuai/p/8431413.html

module.exports = {
    //此项是用来告诉 eslint 找当前配置文件不能往父级查找
    root: true,
    //此项是用来指定 eslint 解析器的，解析器必须符合规则，babel-eslint 解析器是对 babel 解析器的包装使其与 ESLint 解析
    parser: 'babel-eslint',
    //此项是用来指定 javaScript 语言类型和风格，sourceType 用来指定 js 导入的方式，默认是 script，此处设置为 module，指某块导入方式
    parserOptions: {
        sourceType: 'module',
    },
    //此项指定环境的全局变量，下面的配置指定为浏览器环境
    env: {
        browser: true,
    },
    // https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
    // 此项是用来配置标准的 js 风格，就是说写代码的时候要规范的写，如果你使用 vs-code 我觉得应该可以避免出错
    extends: ['standard', 'plugin:vue/essential', 'eslint:recommended'],
    // required to lint *.vue files
    // 此项是用来提供插件的，插件名称省略了 eslint-plugin-，下面这个配置是用来规范 html 的
    plugins: ['html'],
    // add your custom rules here
    // 下面这些 rules 是用来设置从插件来的规范代码的规则，使用必须去掉前缀 eslint-plugin-
    // 主要有如下的设置规则，可以设置字符串也可以设置数字，两者效果一致
    // "off" -> 0 关闭规则
    // "warn" -> 1 开启警告规则
    //"error" -> 2 开启错误规则
    // 了解了上面这些，下面这些代码相信也看的明白了
    rules: {
        // allow paren-less arrow functions
        'arrow-parens': 0,
        // allow async-await
        'generator-star-spacing': 0,
        // allow debugger during development
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
    },
}
