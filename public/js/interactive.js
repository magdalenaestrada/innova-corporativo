function create_tr(table_id) {
    let table_body = document.getElementById(table_id);
    let first_tr = table_body.firstElementChild;
    let tr_clone = first_tr.cloneNode(true);
    let row_number = table_body.children.length;

    table_body.appendChild(tr_clone); // Append the cloned row to the table body
    clean_first_tr(table_body.lastElementChild); // Clean the cloned row if needed

    // Dynamically update classes based on row index
    $(tr_clone).find('.cart-product').removeClass('buscador').addClass('buscador' + row_number);

    // Initialize Select2 on the appropriate element
    let $select2Input = $(tr_clone).find('.buscador' + row_number);
    $select2Input.select2({
        theme: "classic"
      });

    // Remove any extra elements or handle existing values
    // Example: Removing elements that are not needed in cloned rows
    $select2Input.next().next().remove();
}

function clean_first_tr(firstTr){
    let children = firstTr.children;
    children = Array.isArray(children) ? children : Object.values(children);
    children.forEach(x=>{
        if (x !== firstTr.lastElementChild) {
            let inputElement = x.firstElementChild;
            if (inputElement) {
                if (inputElement.type === 'checkbox') {
                    inputElement.checked = false; // Clear the checkbox
                } else {
                    inputElement.value = ''; // Clear other input types
                }
            }
        }
    });
     
}


function remove_tr(This) {
    if(This.closest('tbody').childElementCount == 1)
    {
        Swal.fire('ERROR!!!', 'No elimine todas las filas', 'error');
    }else{
        This.closest('tr').remove();

    }
}