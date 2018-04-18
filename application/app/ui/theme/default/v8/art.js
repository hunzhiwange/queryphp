load('art');

var source = html('v8+art');

var html = template.render(source, $ /*{list: $.list}*/ );

// use (html) to return html
print(html);