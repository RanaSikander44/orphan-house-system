@extends('admin.default')
@section('Page-title', 'Disapprove Enquiry')

@section('content')
<div class="container-fluid px-4">
    <div class="card mt-4 border-0">
        <form action="{{ route('enquiry.disapprove.child', $child->id) }}" method="post">
            @csrf
            <div class="card bg-white px-4 py-3 border-0  rounded">
                <div class="card-body">
                    <label for="" class="fw-bold">Reason why You are disapproving this enquiry
                        <span class="text-danger">*</span></label>
                    <textarea name="reason_disapprove" id="" class="form-control mt-3" required></textarea>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('adoptions') }}" class="btn btn-sm btn-dark text-white">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success text-white">Disapprove</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection