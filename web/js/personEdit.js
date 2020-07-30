(function () {
    'use strict';
    let traitsTable = $("table.trait_table");
    let newTraitRow = $("tr.new_trait").clone();
    $("button.addTraitButton").on("click", function () {
        traitsTable.append(newTraitRow.clone());
        console.log(traitsTable);
    });

}());