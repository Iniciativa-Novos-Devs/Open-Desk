document.querySelectorAll('input[type=radio][name=rating]').forEach((item) =>
{
    item.addEventListener('change', (e) =>
    {
        console.log('New star rating: ' + e.target.value);
    });
});
