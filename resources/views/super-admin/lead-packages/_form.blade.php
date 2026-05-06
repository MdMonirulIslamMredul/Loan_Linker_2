<div class="mb-3">
    <label for="name" class="form-label fw-semibold">Package Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $leadPackage->name ?? '') }}"
        class="form-control" required>
    @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="price" class="form-label fw-semibold">Price</label>
        <input type="number" step="0.01" name="price" id="price"
            value="{{ old('price', $leadPackage->price ?? 0) }}" class="form-control" required>
        @error('price')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="number_of_leads" class="form-label fw-semibold">Number of Leads</label>
        <input type="number" name="number_of_leads" id="number_of_leads"
            value="{{ old('number_of_leads', $leadPackage->number_of_leads ?? 0) }}" class="form-control" required>
        @error('number_of_leads')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="duration" class="form-label fw-semibold">Duration (days)</label>
        <input type="number" name="duration" id="duration" value="{{ old('duration', $leadPackage->duration ?? 30) }}"
            class="form-control" required>
        @error('duration')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="type" class="form-label fw-semibold">Package Type</label>
    <select name="type" id="type" class="form-select" required>
        @php
            $selectedType = old('type', $leadPackage->type ?? 'regular');
        @endphp
        <option value="regular" {{ $selectedType === 'regular' ? 'selected' : '' }}>Regular</option>
        <option value="gift" {{ $selectedType === 'gift' ? 'selected' : '' }}>Gift</option>
        <option value="premium" {{ $selectedType === 'premium' ? 'selected' : '' }}>Premium</option>
    </select>
    @error('type')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label fw-semibold">Description</label>
    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $leadPackage->description ?? '') }}</textarea>
    @error('description')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
