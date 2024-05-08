window.onload = function() {
  //<editor-fold desc="Changeable Configuration Block">

    if ('/' !== window.location.href.substr(-1) &&
        'index.html' !== window.location.href.substr(-10)) {
        window.location.href = window.location.href+'/';
    }

    fetch('/swagger',{
        cache: 'no-cache',
        headers: {
            'user-agent': 'Mozilla/4.0 MDN Example',
            'content-type': 'application/json'
        },
        method: 'GET',
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(apis) {
        var url = '/swagger/web';
        if (window.location.hash) {
            url = window.location.hash.substr(1)
        }

        var primaryName = '';
        for (var i=0;i<apis.length;i++) {
            if (apis[i]['url'].indexOf(url) != -1) {
                primaryName = apis[i]['name'];
            }
        }

        // Build a system
        const ui = SwaggerUIBundle({
            urls: apis,
            'urls.primaryName': primaryName,
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        })

        window.ui = ui
    });

  //</editor-fold>
};
