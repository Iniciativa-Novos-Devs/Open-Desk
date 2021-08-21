function IsJsonString(str)
{
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function isJson(str)
{
    return IsJsonString(str);
}

window.addEventListener('load', ()=>{
    if(window.jQuery)
    {
        jQuery('[data-toggle=tooltip]').tooltip();
    }
});

