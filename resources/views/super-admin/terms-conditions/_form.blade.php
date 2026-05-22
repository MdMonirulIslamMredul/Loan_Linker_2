@php $termsCondition = $termsCondition ?? null; @endphp
@csrf

<div class="mb-4">
    <label for="title" class="form-label fw-bold">Title</label>
    <input type="text" id="title" name="title"
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $termsCondition->title ?? '') }}"
        placeholder="Enter a short heading for these terms">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="content" class="form-label fw-bold">Terms & Conditions Content</label>
    <textarea id="content" name="content" rows="10"
        class="form-control @error('content') is-invalid @enderror"
        placeholder="Enter the full terms and conditions text here">{{ old('content', $termsCondition->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-4">
    <input type="hidden" name="is_active" value="0">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
        {{ old('is_active', $termsCondition->is_active ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">
        Set this entry as the active terms and conditions page.
    </label>
</div>
