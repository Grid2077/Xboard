<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <title>{{$title}}</title>


    <script>
        (() => {
            const KEY = 'VUE_NAIVE_LOCALE';

            const applyLang = (raw) => {
                try {
                    const locale = JSON.parse(raw)?.value;

                    if (
                        typeof locale === 'string' &&
                        locale &&
                        document.documentElement.lang !== locale
                    ) {
                        document.documentElement.lang = locale;
                    }
                } catch { }
            };

            applyLang(localStorage.getItem(KEY));

            const originalSetItem = Storage.prototype.setItem;

            Storage.prototype.setItem = function (key, value) {
                const result = originalSetItem.call(this, key, value);

                if (this === localStorage && key === KEY) {
                    applyLang(value);
                }

                return result;
            };

            window.addEventListener('storage', (e) => {
                if (e.storageArea === localStorage && e.key === KEY) {
                    applyLang(e.newValue);
                }
            });
        })();
    </script>


    <script type="module" crossorigin src="/theme/{{$theme}}/assets/umi.js"></script>
</head>

<body>

    <script>
        window.routerBase = "/";
        window.settings = {
            title: '{{$title}}',
            assets_path: '/theme/{{$theme}}/assets',
            theme: {
                color: '{{ $theme_config['theme_color'] ?? "default" }}',
            },
            version: '{{$version}}',
            background_url: '{{$theme_config['background_url']}}',
            description: '{{$description}}',
            i18n: [
                'zh-CN',
                'en-US',
                'ja-JP',
                'vi-VN',
                'ko-KR',
                'zh-TW',
                'fa-IR',
                'ru-RU'
            ],
            logo: '{{$logo}}'
        }
    </script>
    <div id="app"></div>
    {!! $theme_config['custom_html'] !!}
</body>

</html>
