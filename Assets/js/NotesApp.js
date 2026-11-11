KB.on('dom.ready', function () {
    $(document).on('click', '.notes-filter-helper', function (event) {
        event.preventDefault();
        const filterDistinctFunc = (value, index, array) => array.indexOf(value) === index
        const inputSelector = 'input[name="searchTags"]';
        const currentValue = $(inputSelector).val();
        const additionalValueEl = event.target;
        const additionalValue = additionalValueEl.tagName === 'INPUT' ?
            additionalValueEl.id :
            additionalValueEl.tagName === 'LABEL' ?
                additionalValueEl.previousElementSibling.id :
                additionalValueEl.firstElementChild.id;
        const isUnclick = currentValue.split(',').includes(additionalValue);
        const unclickFunc = (value, _, __) => isUnclick ? value !== additionalValue : true;
        const initialNewValue = currentValue === '' ? additionalValue :
            currentValue + "," + additionalValue
        const newValue = initialNewValue
            .split(',')
            .filter(filterDistinctFunc)
            .filter(unclickFunc)
            .join(',');
        $(inputSelector).val(newValue);
        $('form#notes-search-form').submit();
    })
});

