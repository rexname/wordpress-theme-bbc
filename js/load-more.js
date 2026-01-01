document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('load-more');
    const loadingIndicator = document.getElementById('loading-indicator');
    const container = document.querySelector('.site-main');

    if (!loadMoreBtn) {
        return;
    }

    loadMoreBtn.addEventListener('click', function () {
        let offset = parseInt(this.dataset.offset, 10);
        const catId = this.dataset.cat;

        loadMoreBtn.style.display = 'none';
        loadingIndicator.style.display = 'block';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', bbc_ajax.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        xhr.onload = function () {
            if (this.status >= 200 && this.status < 400) {
                const response = JSON.parse(this.response);
                if (response.success && response.data.html) {
                    const newContent = document.createElement('div');
                    newContent.innerHTML = response.data.html;
                    container.insertBefore(newContent, loadMoreBtn.parentElement);
                    loadMoreBtn.dataset.offset = offset + response.data.post_count;
                    loadMoreBtn.style.display = '';
                    if (!response.data.has_more) {
                        loadMoreBtn.parentElement.removeChild(loadMoreBtn);
                    }
                } else {
                    loadMoreBtn.parentElement.removeChild(loadMoreBtn);
                }
            } else {
                loadMoreBtn.style.display = 'block';
            }
            loadingIndicator.style.display = 'none';
        };

        xhr.onerror = function () {
            loadingIndicator.style.display = 'none';
            loadMoreBtn.style.display = 'block';
        };

        const data = `action=bbc_load_more&nonce=${bbc_ajax.nonce}&offset=${offset}&cat_id=${catId}`;
        xhr.send(data);
    });
});
