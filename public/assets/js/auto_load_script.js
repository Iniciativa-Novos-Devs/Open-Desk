function documentIsLoaded()
{
    return document.readyState === "complete" || document.readyState === "interactive";
}

function windowIsLoaded()
{
    return documentIsLoaded();
}

function loadScript(script_url)
{
    var script = document.createElement('script');
    script.src = script_url;
    document.head.appendChild(script);
}

function loadAllScripts()
{
    if(!documentIsLoaded())
        return null;

    if(!window.script_urls || !(window.script_urls.length > 0))
        return null;

    window.script_urls.forEach((item) => {
        if(item.url)
            loadScript(item.url);
    });
}

function addScriptToAppendAfterLoad(script_url)
{
    window.script_urls = window.script_urls && window.script_urls.length > 0
                        ? window.script_urls : [];

    window.script_urls.push({url: script_url});

    loadAllScripts();
}

document.addEventListener('DOMContentLoaded', (event) => {
    loadAllScripts();
});
