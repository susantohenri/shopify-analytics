function shopifyAnalyse() {
    document.querySelector('.shopify-analytics .results.error').classList.add('d-none')
    document.querySelector('.shopify-analytics .results.not-shopify').classList.add('d-none')
    document.querySelector('.shopify-analytics .results.success').classList.add('d-none')

    var button = document.querySelector('[onclick="shopifyAnalyse()"]')
    var buttonText = button.innerHTML
    var url = document.querySelector('[name="site-url"]').value.trim()
    if ('' === url) return false;
    button.innerHTML = 'Please Wait'

    const formData = new FormData();
    formData.append('url', url);

    fetch(shopify_analytics.analytics_url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: formData
    })
        .then(res => res.json())
        .then(res => {
            button.innerHTML = buttonText
            res = JSON.parse(res)
            if ('' !== res.theme && null !== res.theme) {
                document.querySelector('.shopify-analytics .results.success .resultMSG').innerHTML = `
                    Success!
                `
                document.querySelector('.shopify-analytics .results.success').classList.remove('d-none')
            } else {
                document.querySelector('.shopify-analytics .results.not-shopify .resultMSG').innerHTML = `${res.url} not using Shopify`
                document.querySelector('.shopify-analytics .results.not-shopify').classList.remove('d-none')
            }
        })
        .catch(e => {
            document.querySelector('.shopify-analytics .results.error .resultMSG').innerHTML = e
            document.querySelector('.shopify-analytics .results.error').classList.remove('d-none')
        })
}