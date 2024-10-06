function cc_format(value) {
    var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
    var matches = v.match(/\d{4,15}/g);
    var match = matches && matches[0] || ''
    var parts = []

    for (i = 0, len = match.length; i < len; i += 4) {
        parts.push(match.substring(i, i + 4))
    }

    if (parts.length) {
        return parts.join(' ')
    } else {
        return value
    }
}

function dateexpiration_format(e) {
    var inputChar = String.fromCharCode(event.keyCode);
    var code = event.keyCode;
    var allowedKeys = [8];
    if (allowedKeys.indexOf(code) !== -1) {
        return;
    }

    // Ces expressions régulières sortent d'internet et permettent la vérification d'une date d'expiration au bon format
    // Elles ajoutent aussi le "/" au milieu etc...
    event.target.value = event.target.value.replace(
        /^([1-9]\/|[2-9])$/g, '0$1/'
    ).replace(
        /^(0[1-9]|1[0-2])$/g, '$1/'
    ).replace(
        /^([0-1])([3-9])$/g, '0$1/$2'
    ).replace(
        /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2'
    ).replace(
        /^([0]+)\/|[0]+$/g, '0'
    ).replace(
        /[^\d\/]|^[\/]*$/g, ''
    ).replace(
        /\/\//g, '/'
    );
}

document.getElementById('date_exp').addEventListener('keydown', (event) => {
    dateexpiration_format(event);
});
document.getElementById('carte_bancaire').addEventListener('keypress', (event) => {
    let numeroActuel = event.target.value;
    let numeroFormatter = cc_format(numeroActuel);

    document.getElementById("carte_bancaire").value = numeroFormatter;
});