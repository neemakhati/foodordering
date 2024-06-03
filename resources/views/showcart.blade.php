<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    @include('homecss')

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
@extends('homeheader')

<div id="top">
    <table align="center" width="500px" style="border: 1px solid #fb5849;">
        <tr>
            <!-- <th style="padding:30px;">Image</th> -->
            <th style="border: 1px solid #fb5849; color: #fb5849; padding:30px;">Title</th>
            <th style="border: 1px solid #fb5849;color: #fb5849;padding:30px;">Price</th>
            <th style="border: 1px solid #fb5849;color: #fb5849;padding:30px;">Quantity</th>
            <th style="border: 1px solid #fb5849;color: #fb5849;padding:30px;">Action</th>
            <!-- <th style="padding:30px;">Total</th> -->
        </tr>
        <form id="checkoutForm" action="{{ url('checkout') }}" method="post">
            @csrf
            @forelse ($cartItems as $cartItem)
                <tr>
                    <td style="border: 1px solid #fb5849;padding:30px;">
                        <input type="text" name="name[]" value="{{ $cartItem->food->title }}" hidden>
                        {{ $cartItem->food->title }}</td>
                    <td style="border: 1px solid #fb5849;padding:30px;">
                        <input type="text" name="price[]" value="{{ $cartItem->food->price }}" hidden>
                        {{ $cartItem->food->price }}</td>
                    <td style="border: 1px solid #fb5849;padding:30px;">
                        <input type="number" name="quantity[]" value="{{ $cartItem->quantity }}" min="1" style="width: 60px; text-align: center;">
                    </td>
                    <td style="border: 1px solid #fb5849;padding:30px;">
                        <a href="{{ url('deletecart', $cartItem->id) }}" class="remove-item" style='color: #fb5849;'>Remove</a>
                    </td>
                </tr>
            @empty
                <tr class="empty-cart">
                    <td colspan="4" style="padding:30px; text-align: center; color: #fb5849;">Your cart is empty</td>
                </tr>
        @endforelse
    </table>
    <div align="center" style="padding:10px;">
        <button class="btn btn-primary" id="showForm" type="button" style="background-color: #fb5849;" {{ count($cartItems) == 0 ? 'disabled' : '' }}>Order Now</button>
    </div>
    <div id="appear" align="center" style="padding: 20px; display: none; border: 1px solid #ccc; background-color: #fb5849; border-radius: 5px; max-width: 300px; margin: 0 auto;">
        <div style="margin-bottom: 10px;">
            <input type="text" name="firstname" placeholder="Enter Name" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="address" placeholder="Enter Address" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="text" name="phone" placeholder="Enter Phone" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 10px;">
            <input type="submit" name="submit" id="order" class="btn btn-success" value="Order Confirm" style="width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #28a745; color: #fff; cursor: pointer;">
        </div>
        <button class="btn btn-danger" type="button" id="cancel" style="width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #dc3545; color: #fff; cursor: pointer;">Cancel</button>
    </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {
        $(document).on("click", "#showForm", function () {
            $("#appear").show();
        });

        $(document).on("click", "#cancel", function () {
            $("#appear").hide();
        });

        $('#checkoutForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("ordermail") }}',
                        data: $('#checkoutForm').serialize(),
                        success: function(response) {
                            alert('Order placed and email sent.');

                            $('#checkoutForm')[0].reset();
                            $('#top table tr').not(':first').remove();
                            $("#appear").hide();
                            showEmptyCartMessage();
                        },
                        error: function(error) {
                            alert('Order placed but failed to send email.');
                            // Clear the form and cart items
                            $('#checkoutForm')[0].reset();
                            $('#top table tr').not(':first').remove();
                            $("#appear").hide();
                            showEmptyCartMessage();
                        }
                    });
                },
                error: function(error) {
                    alert('Failed to place order.');
                }
            });
        });

        function showEmptyCartMessage() {
            $('#top table').append('<tr class="empty-cart"><td colspan="4" style="padding:30px; text-align: center; color: #fb5849;">Your cart is empty</td></tr>');
            $('#showForm').attr('disabled', true);
        }

        // Remove item and update cart
        $(document).on('click', '.remove-item', function (e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                success: function (response) {
                    row.remove();
                    if ($('#top table tr').length == 1) {
                        showEmptyCartMessage();
                    }
                },
                error: function (error) {
                    alert('Failed to remove item.');
                }
            });
        });
    });
</script>
<div style="position: relative; margin-top:250px; width: 100%">
    @include('homefooter')
</div>
@include('homescripts')

</body>
</html>
