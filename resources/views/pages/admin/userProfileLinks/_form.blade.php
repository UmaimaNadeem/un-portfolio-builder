<div class="mb-3">
    <label>Website Name</label>
    <input type="text" name="website_name" value="{{ old('website_name', $userProfileLink->website_name ?? '') }}" class="form-control" required>
    @error('website_name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Stacks (comma separated)</label>
    <input type="text" name="stack" value="{{ old('stack', $userProfileLink->stack ?? '') }}" class="form-control" placeholder="e.g. Laravel, React, UI/UX" required>
    @error('stack') <small class="text-danger">{{ $message }}</small> @enderror
</div>


<div class="mb-3">
    <label>Overview</label>
    <textarea name="overview" class="form-control">{{ old('overview', $userProfileLink->overview ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Portfolio Link</label>
    <input type="url" name="portfolio_link" value="{{ old('portfolio_link', $userProfileLink->portfolio_link ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>GitHub</label>
    <input type="url" name="github" value="{{ old('github', $userProfileLink->github ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>LinkedIn</label>
    <input type="url" name="linkedin" value="{{ old('linkedin', $userProfileLink->linkedin ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>WhatsApp</label>
    <input type="text" name="whatsapp" value="{{ old('whatsapp', $userProfileLink->whatsapp ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Instagram</label>
    <input type="text" name="instagram" value="{{ old('instagram', $userProfileLink->instagram ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>CV/Resume (PDF, DOC)</label>
    <input type="file" name="cv_resume" class="form-control">
    @if(!empty($userProfileLink->cv_resume))
        <p>Current: <a href="{{ asset($userProfileLink->cv_resume) }}" target="_blank">Download</a></p>
    @endif
</div>

<button type="submit" class="btn btn-success">{{ $submit }}</button>
<a href="{{ route('user-profile-links.index') }}" class="btn btn-secondary">Cancel</a>
