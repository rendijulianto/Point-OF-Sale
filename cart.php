<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<table id="myTable" border='1'>
  <thead>
    <tr>
      <th>No</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Sub Total</th>
    </tr>
  </thead>
  <tr>
    <td>1</td>
    <td><input type="number" data-id="98" value="1" class="quant"/></td>
    <td class="price" data-price="30">30</td>
    <td class="amount">30</td>
  </tr>
  <tr>
    <td>2</td>
    <td><input type="number" data-id="99" value="0" class="quant"/></td>
    <td class="price" data-price="10">10</td>
    <td class="amount">30</td>
  </tr>
  <tfoot>
    <tr>
      <td colspan="3"><b>Total Belanja :</b></td>
      <td ><input class="total" type="text"></td>
    </tr>
  </tfoot>
</table>


<script type="text/javascript">
$(document).ready(function() {
  update();
  $(".quant").change(function() {
    //this: context of the input that was changed
    console.log('calling /Cart/AddTocart; id:',$(this).attr('data-id'),' quantity: ', $(this).val());
    $.get(
      '/Cart/AddTocart', {
        id: $(this).attr('data-id'),
        returnUrl: '',
        quantity: $(this).val()
      });
    update();
  });

  function update() {
    var sum = 0.0;
    var quantity;
    $('#myTable > tbody  > tr').each(function() {
      quantity = $(this).find('.quant').val();
      var price = parseFloat($(this).find('.price').attr('data-price').replace(',', '.'));
      var amount = (quantity * price);

      sum += amount;
      $(this).find('.amount').text('' + amount);
    });
    $('.total').val(sum);
  }
});
</script>