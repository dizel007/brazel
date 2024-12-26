function add_row(StrNumber) {
// alert("StrNumber=" + StrNumber);

  // ******************************        номер строки где тыкнули ************** 

var Str_Number = document.getElementById(StrNumber).value;
// alert("33333=" + Str_Number);
Str_Number = StrNumber.replace(/[^0-9]/g,"");
real_string = +Str_Number + 1;
insert_array_string = real_string+1;
Str_Number = +Str_Number + 2;
Str_Number_for = +Str_Number + 1;
// console.log('real_string=' + real_string);
// console.log('insert_array_string=' + insert_array_string);

// ******************************  обновляем количество строк в КП  
    all_kolvo = document.getElementById('all_kolvo').value;
    all_kolvo= +all_kolvo + 1;
    net = document.getElementById('all_kolvo').value;
    document.getElementById('all_kolvo').value = all_kolvo; 

// ******************************        Nf,kbwe таблицу  ************************************** 

  var table = document.getElementById("Table_products");

// Тут вся наша таблица
i=0;
prod_array  = [];
  for (let row of table.rows) {
    j=0;
    str_array =[];
     for (let cell of row.cells) {
      zzz= cell.querySelector('input');
       if (zzz) {
        zzz1 = zzz.value;
        /// изменяем значение NAME  в наименовании товар
            if ( j == 1 ) {
              name_number = +i - 1;
              if (insert_array_string > i) {
              zzz1=zzz.setAttribute("name","name" + name_number);
              } else {
                zzz1=zzz.setAttribute("name","name" + i);
              }
            }
        /// изменяем значение NAME  в Ед.Изм товар
                if ( j == 2 ) {
                  name_number = +i -1;
                  if (insert_array_string > i) {
                  zzz1=zzz.setAttribute("name","ed_izm" + name_number);
                  } else {
                    zzz1=zzz.setAttribute("name","ed_izm" + i);
                  }
                }
      /// изменяем значение NAME  в Кол-во
              if ( j == 3 ) {
                  name_number = +i -1;
                  if (insert_array_string > i) {
                    zzz1=zzz.setAttribute("id","kol" + name_number);
                  zzz1=zzz.setAttribute("name","kol" + name_number);
                  } else {
                    zzz1=zzz.setAttribute("id","kol" + i);
                    zzz1=zzz.setAttribute("name","kol" + i);
                  }
                }
      /// изменяем значение NAME  в Цена
      if ( j == 4 ) {
        name_number = +i -1;
        if (insert_array_string > i) {
        zzz1=zzz.setAttribute("id","price" + name_number);
        zzz1=zzz.setAttribute("name","price" + name_number);
        } else {
          zzz1=zzz.setAttribute("id","price" + i);
          zzz1=zzz.setAttribute("name","price" + i);
        }
      }

            /// изменяем значение NAME  в 
            if ( j == 5 ) {
              name_number = +i -1;
              if (insert_array_string > i) {
              zzz1=zzz.setAttribute("id","sum_price" + name_number);
              zzz1=zzz.setAttribute("name","sum_price" + name_number);
              
              } else {
                zzz1=zzz.setAttribute("id","sum_price" + i);
                zzz1=zzz.setAttribute("name","sum_price" + i);
              }
            }



        /// изменяет номер я кнопке добавления строки
              if (j == 6)       {
                place_str = 'num_col_' + i;
                name_number = +i -1;
                if (insert_array_string > i) {
                  name_number = +i -1;
                  place_str = 'num_col_' + name_number;
                  cell.innerHTML="<input size =\"1\" type=\"button\" value=\"+\" onclick=\"add_row('"+ place_str+  "')\">";
                  } else {
                    place_str = 'num_col_' + i;
                    cell.innerHTML="<input size =\"1\" type=\"button\" value=\"+\" onclick=\"add_row('"+ place_str+  "')\">";
                   
                  }

                cell.innerHTML="<input size =\"1\" type=\"button\" value=\"+\" onclick=\"add_row('"+ place_str+  "')\">";
              }

            /// изменяет номер я кнопке удаления строки
          
              if (j == 7)       {
                place_str = 'num_col_' + i;
                name_number = +i -1;
                if (insert_array_string > i) {
                  name_number = +i -1;
                  place_str = 'num_col_' + name_number;
                  cell.innerHTML="<input size =\"1\" type=\"button\" value=\"-\" onclick=\"delete_row('"+ place_str+  "')\">";
                  
                  } else {
                    place_str = 'num_col_' + i;
                    cell.innerHTML="<input size =\"1\" type=\"button\" value=\"-\" onclick=\"delete_row('"+ place_str+  "')\">";
                   
                  }

                cell.innerHTML="<input size =\"1\" type=\"button\" value=\"-\" onclick=\"delete_row('"+ place_str+  "')\">";
              }
            
        // str_array[j] = zzz1;
        // console.log(zzz1);
       } else {
        if ( i < insert_array_string) 
        str_array[j] = i;
        else {
          next_i = +i +1;
          str_array[j] = next_i; 
          row.setAttribute("id",'num_col_'+i);
          cell.innerHTML= "<p class =\"table_p\">" +next_i+ "</p>" ;

        }
       }
 
 prod_array[i] = str_array;
    j++;
     }
    //  console.table(str_array);
   i++;
}




  // console.table(prod_array);


var newRow=table.insertRow(Str_Number);

place_str = 'num_col_' + real_string;
new_name ='name' + real_string;
new_ed_izm = 'ed_izm' + real_string;
new_kol = 'kol' + real_string;
new_price = 'price' + real_string;
new_sum_price = 'sum_price' + real_string;

// alert("place_str=" + place_str);

var newCell = newRow.insertCell(0);
newCell.innerHTML="<p class =\"table_p\">" + Str_Number + "</p>";

newCell = newRow.insertCell(1);
newCell.innerHTML="<input required size =\"100\" name=\"" + new_name + "\"  type=\"text\" >";
newCell = newRow.setAttribute("id",place_str);

newCell = newRow.insertCell(2);
newCell.innerHTML="<input size =\"2\"   type=\"text\" name=\"" + new_ed_izm + "\">";

newCell = newRow.insertCell(3);
newCell.innerHTML="<input required onkeyup=\"CalculateItem();\"  onkeydown=\"CalculateItem();\" onchange=\"CalculateItem();\" onfocus=\"CalculateItem()\"; size =\"1\" step=\"0.01\"  type=\"number\" id=\"" + new_kol + "\" name=\"" + new_kol + "\">";

newCell = newRow.insertCell(4);
newCell.innerHTML="<input required onkeyup=\"CalculateItem();\"  onkeydown=\"CalculateItem();\" onchange=\"CalculateItem();\" onfocus=\"CalculateItem()\"; size =\"1\"  step=\"0.01\"  type=\"number\" id=\"" + new_price + "\" name=\"" + new_price + "\">";

newCell = newRow.insertCell(5);
newCell.innerHTML="<input readonly size =\"1\"  type=\"number\" id=\"" + new_sum_price + "\" name=\"" + new_sum_price + "\" value = \"\">";

newCell = newRow.insertCell(6);
newCell.innerHTML="<input size =\"1\" type=\"button\" value=\"+\" onclick=\"add_row('"+ place_str+  "')\">";

newCell = newRow.insertCell(7);
newCell.innerHTML="<input size =\"1\"  type=\"button\" value=\"-\" onclick=\"delete_row('"+ place_str+  "')\">";

}


function delete_row(StrNumber)
{
  
  // ******************************  обновляем количество строк в КП  
  all_kolvo = document.getElementById('all_kolvo').value;
  all_kolvo= +all_kolvo - 1;
  net = document.getElementById('all_kolvo').value;
  document.getElementById('all_kolvo').value = all_kolvo; 

  Str_Number = StrNumber.replace(/[^0-9]/g,"");
  Str_to_del = +Str_Number +1;  
  // alert ('DEL Str_to_del = ' + Str_to_del);

  var table = document.getElementById("Table_products");
  
  var row = table.getElementsByTagName('tr');
        if(row.length!='2'){
            // row[row.length - 1].outerHTML='';
            table.deleteRow(Str_to_del);
        }
    
  
  // var Str_Number = document.getElementById(StrNumber).value;

  // var row = table.getElementsByTagName('tr');
  //       if(row.length!='2'){
  //           row[row.length - 1].outerHTML='';
  //       }
table = document.getElementById("Table_products");

  // Тут вся наша таблица
i=0;
prod_array  = [];
  for (let row of table.rows) {
    if ( i == 0 ) {
      i++;
      continue;
    }
    j=0;
    str_array =[];
     for (let cell of row.cells) {
      zzz= cell.querySelector('input');
       if (zzz) {
        // console.log(i);
        name_number = +i -1;
        /// изменяем значение NAME  в наименовании товар
          if ( j == 1 ) {
                zzz.setAttribute("name","name" + name_number);
                zzz.setAttribute("id","name" + name_number);
              }
         /// изменяем значение NAME  в Ед.Изм товар
                if ( j == 2 ) {
                  zzz.setAttribute("name","ed_izm" + name_number);
                  zzz.setAttribute("id","ed_izm" + name_number);
                }
      /// изменяем значение NAME  в Кол-во
              if ( j == 3 ) {
             zzz.setAttribute("name","kol" + name_number);
             zzz.setAttribute("id","kol" + name_number);
                   }
      /// изменяем значение NAME  в Цена
      if ( j == 4 ) {
       zzz.setAttribute("name","price" + name_number);
       zzz.setAttribute("id","price" + name_number);
        }


      /// изменяем значение NAME  в Цена
      if ( j == 5 ) {
        zzz.setAttribute("name","sum_price" + name_number);
        zzz.setAttribute("id","sum_price" + name_number);
         }
 
          
        /// изменяет номер я кнопке добавления строки
          if (j == 6)       {
            place_str = 'num_col_' + name_number;
            cell.innerHTML="<input size =\"1\" type=\"button\" value=\"+\" onclick=\"add_row('"+ place_str+  "')\">";
                    }
        /// изменяет номер я кнопке удаления строки
           if (j == 7)       {
             if (all_kolvo ==1) {
             place_str = 'num_col_' + name_number;
             cell.innerHTML="<input size =\"1\" type=\"button\" value=\"-\" >";
             } else {
              place_str = 'num_col_' + name_number;
              cell.innerHTML="<input size =\"1\" type=\"button\" value=\"-\" onclick=\"delete_row('"+ place_str+  "')\">"; 
             }
              }
            
        // str_array[j] = zzz1;
        // console.log(zzz1);
       } else {
          next_i = +i -1;
          // console.log(next_i);
          // str_array[j] = next_i; 
          row.setAttribute("id",'num_col_'+next_i);
          cell.innerHTML= "<p class =\"table_p\">" + i+ "</p>" ;

        
       }
    j++;
     }
    //  console.table(str_array);
   i++;
}
CalculateSummaKp();
}

