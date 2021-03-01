<script>
var currency_symbol="<?=$currency_symbol?>";
var disp_currency="<?=$disp_currency?>";
var is_space_between_currency_symbol="<?=$is_space_between_currency_symbol?>";
var thousand_separator="<?=$thousand_separator?>";
var decimal_separator="<?=$decimal_separator?>";
var decimal_number="<?=$decimal_number?>";

function format_amount(amount) {
    var symbol_space="";
	if(is_space_between_currency_symbol == "1") {
		symbol_space=" "
	} else {
		symbol_space=""
	}

	if(disp_currency =="prefix") {
		return currency_symbol + symbol_space +amount;
	} else { 
	  return amount +symbol_space +currency_symbol;
	}
}

function formatMoney(n, c, d, t) {
	var c = isNaN(c = Math.abs(c)) ? decimal_number: c,
	d = d == undefined ?decimal_separator : d,
	t = t == undefined ? thousand_separator : t,
	s = n < 0 ? "-" : "",
	i = String(parseInt(n = Math.abs(Number(n)
 || 0).toFixed(c))),
	j = (j = i.length) > 3 ? j % 3 : 0;
	
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function removeLastComma(strng) {        
	var n=strng.lastIndexOf(",");
	var a=strng.substring(0,n);
	return a;
}
</script>
