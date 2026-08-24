@extends('layouts.customer')

@section('title', 'My Profile | Luxe Store')

@section('content')
<div class="dashboard-card profile-edit-card">
    <div class="dashboard-card-head profile-edit-head">
      <div>
        <span class="eyebrow">Account Settings</span>
        <h1>My Profile</h1>
        <p>Update your personal information and profile photo.</p>
      </div>
      <a href="{{ route('customer.dashboard') }}" class="view-all-link">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
      </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="profile-edit-form">
    @csrf
    @method('put')

      <div class="profile-edit-avatar-section">
        @if($customer->photoUrl())
          <img src="{{ $customer->photoUrl() }}" alt="{{ $customer->name }}" class="profile-edit-avatar" id="profilePreview">
        @else
          <span class="profile-edit-avatar profile-edit-initials" id="profileInitials">{{ $customer->initials() }}</span>
          <img src="" alt="Profile preview" class="profile-edit-avatar d-none" id="profilePreview">
        @endif

        <div>
          <label for="profile_photo" class="btn-profile-upload">
            <i class="bi bi-camera"></i> Change Photo
          </label>
          <input type="file" name="profile_photo" id="profile_photo" accept="image/jpeg,image/png,image/webp" class="d-none">
          <small>JPG, PNG or WebP. Maximum 2 MB.</small>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-md-6">
          <label for="name" class="profile-field-label">Full Name</label>
          <input type="text" id="name" name="name" class="profile-field-input" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="col-md-6">
          <label for="email" class="profile-field-label">Email Address</label>
          <input type="email" id="email" name="email" class="profile-field-input" value="{{ old('email', $customer->email) }}" required>
        </div>

        <div class="col-md-6">
          <label for="phone" class="profile-field-label">Phone Number</label>
          <input type="text" id="phone" name="phone" class="profile-field-input" value="{{ old('phone', $customer->phone) }}" placeholder="Enter phone number">
        </div>
      </div>

      <div class="profile-edit-actions">
        <a href="{{ route('customer.dashboard') }}" class="btn-profile-cancel">Cancel</a>
        <button type="submit" class="btn-profile-save">
          <i class="bi bi-check2"></i> Save Changes
        </button>
      </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('profile_photo');
  const preview = document.getElementById('profilePreview');
  const initials = document.getElementById('profileInitials');

  if (!input || !preview) return;

  input.addEventListener('change', function () {
    const file = this.files && this.files[0];
    if (!file) return;

    preview.src = URL.createObjectURL(file);
    preview.classList.remove('d-none');
    if (initials) initials.classList.add('d-none');
  });
});
</script>
@endsection
