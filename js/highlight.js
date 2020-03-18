/**
 * Require JQuery
 */
$(document).ready (() =>
{
    // When a referencing column is hovered,
    // Highlight the referenced table, and the referenced column
    $('.reference-column').hover (function () {
        // Keep the reference
        let thisObj = $(this);
        let details = {
            table: thisObj.attr ('data-reftable'),
            column: thisObj.attr ('data-refcolumn')
        };
        // Find the referenced table, acolumn
        let refTable = $(`.table-container[data-table=${details.table}]`);
        let refColumn =  refTable.find (`li[data-column=${details.column}]`);
        // Animate the effect
        refTable.css ({transform: 'scale(1.15)'});
        refColumn.css ('border-left', '6px solid #512da8');
    });
    // Reset anims when mouse leaves
    $('.reference-column').mouseleave(() => 
    {
        $('.table-container').css ({transform: 'scale(1)'});
        $('li').css ('border-left', '6px solid transparent');
    });
});