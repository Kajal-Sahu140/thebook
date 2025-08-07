@extends('admin.master')

@section('content')
<style>
    .breadcrumb {
        background-color: #e9eef2;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
    }
    .breadcrumb li a {
        text-decoration: none;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: '/';
        padding: 0 0.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.return') }}">Return Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Return Order</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Return Order Details</h1>

        <div class="card">
            <div class="card-header">
                Return Order #{{ $returnOrder->id }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>User Name</th>
                            <td>{{ $returnOrder->user->name ?? 'User' }}</td>
                        </tr>
                        <tr>
                            <th>Order ID</th>
                            <td>{{ $returnOrder->order->order_id }}</td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $returnOrder->product->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Product Price</th>
                            <td>${{ $returnOrder->product->base_price }}</td>
                        </tr>
                        <tr>
                            <th>Product Image</th>
                            <td><img src="{{$returnOrder->product->images->first()->image_url}}" height="60px"/></td>
                        </tr>
                        <tr>
                            <th>Return Reason</th>
                            <td>{{ $returnOrder->reason->reason }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $returnOrder->return_status == 'approved' ? 'success' : ($returnOrder->return_status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($returnOrder->return_status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Comments</th>
                            <td>{{ $returnOrder->return_comments ?? 'No comments' }}</td>
                        </tr>
                        @if ($returnOrder->refund)
                            <tr>
                                <th>Refund Status</th>
                                <td>
                                    <span class="badge bg-{{ $returnOrder->refund->refund_status == 'approved' ? 'success' : ($returnOrder->refund->refund_status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($returnOrder->refund->refund_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Refund Amount</th>
                                <td>${{ $returnOrder->refund->refund_amount }}</td>
                            </tr>
                            <tr>
                                <th>Refund Comments</th>
                                <td>{{ $returnOrder->refund->refund_comments ?? 'No comments' }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                @if ($returnOrder->return_status == 'Approved' && !$returnOrder->refund)
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#refundModal">
                        Process Refund
                    </button>
                @endif
            </div>
        </div>
    </div>
</main>

<!-- Refund Modal -->
@if ($returnOrder->return_status == 'Approved' && !$returnOrder->refund)
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="refundForm" action="{{ route('admin.refund.create', $returnOrder->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_return_order_id" value="{{ $returnOrder->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refund_amount" class="form-label">Refund Amount</label>
                        <input type="number" class="form-control" name="refund_amount" id="refund_amount" step="0.01" min="0" maxlength="8" value="{{ old('refund_amount') }}">
                        <span id="refund_amount_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="refund_comments" class="form-label">Comments (Optional)</label>
                        <textarea class="form-control" name="refund_comments" id="refund_comments" rows="3">{{ old('refund_comments') }}</textarea>
                        <span id="refund_comments_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    @if ($errors->any())
        var refundModal = new bootstrap.Modal(document.getElementById('refundModal'));
        refundModal.show();
    @endif

    $("#refundForm").validate({
        rules: {
            refund_amount: {
                required: true,
                number: true,
                min: 0,
                maxlength: 8
            },
            refund_comments: {
                maxlength: 500
            }
        },
        messages: {
            refund_amount: {
                required: "Please enter a refund amount.",
                number: "Enter a valid number.",
                min: "Amount cannot be less than 0.",
                maxlength: "Amount cannot exceed 8 digits."
            },
            refund_comments: {
                maxlength: "Comments cannot exceed 500 characters."
            }
        },
        errorElement: "span",
        errorClass: "text-danger",
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success) {
                        var refundModalEl = document.getElementById('refundModal');
                        var refundModal = bootstrap.Modal.getInstance(refundModalEl);

                        refundModal.hide();
                        $(refundModalEl).on('hidden.bs.modal', function () {
                            window.location.reload();
                        });
                    } else {
                        $(".text-danger").remove();
                        $.each(response.errors, function (key, value) {
                            $('#' + key + '_error').text(value);
                        });
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    $('#refundModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });
});
</script>
