// Замените на свой API-ключ
var token = "ef0e1d4c5e875f38344a698c7bfae1f02078f7ed";

function join(arr /*, separator */) {
  var separator = arguments.length > 1 ? arguments[1] : ", ";
  return arr.filter(function(n){return n;}).join(separator);
}


function showSuggestion(suggestion) {
  console.log(suggestion);
  var data = suggestion.data;
  if (!data)
    return;
  
 
  if (data.name) {
    $("#name_short").val(data.name.short_with_opf || "");
    $("#name_full").val(data.name.full_with_opf || "");
  }
  
     
  $("#inn").val(data.inn);
  // $("#inn_kpp").val(join([data.inn, data.kpp], " / "));
  $("#kpp").val(data.kpp);

  if (data.address) {
    var address = "";
    if (data.address.data.qc == "0") {
      address = join([data.address.data.postal_code, data.address.value]);
    } else {
      address = data.address.data.source;
    }
    $("#address").val(address);
  }
}

$("#party").suggestions({
  token: token,
  type: "PARTY",
  count: 5,
  /* Вызывается, когда пользователь выбирает одну из подсказок */
  onSelect: showSuggestion
});