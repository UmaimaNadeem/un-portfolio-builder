@extends('layouts.member')

@section('content')
<div class="unMainContainer">
    <h2 class="text-center mb-4">Create Full Portfolio</h2>
    <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Personal Info --}}
        <h4>Personal Information</h4>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>

        {{-- Profile Links --}}
        <h4>Profile Links</h4>
        <div class="mb-3">
            <label>Website Name</label>
            <input type="text" name="website_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stack (comma separated)</label>
            <input type="text" name="stack" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Overview</label>
            <textarea name="overview" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Portfolio Link</label>
            <input type="url" name="portfolio_link" class="form-control">
        </div>
        <div class="mb-3">
            <label>GitHub</label>
            <input type="url" name="github" class="form-control">
        </div>
        <div class="mb-3">
            <label>LinkedIn</label>
            <input type="url" name="linkedin" class="form-control">
        </div>
        <div class="mb-3">
            <label>WhatsApp</label>
            <input type="url" name="whatsapp" class="form-control">
        </div>
        <div class="mb-3">
            <label>Instagram</label>
            <input type="url" name="instagram" class="form-control">
        </div>
        <div class="mb-3">
            <label>CV/Resume</label>
            <input type="file" name="cv_resume" class="form-control">
        </div>

        {{-- Work Experience (Single for now) --}}
        <h4>Work Experience</h4>
        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="work[company_name]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Job Title</label>
            <input type="text" name="work[job_title]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="work[start_date]" class="form-control">
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="work[end_date]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="work[description]" class="form-control"></textarea>
        </div>

        {{-- Education (Single for now) --}}
        <h4>Education</h4>
        <div class="mb-3">
            <label>Degree</label>
            <input type="text" name="education[degree]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Institution</label>
            <input type="text" name="education[institution]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Start Year</label>
            <input type="date" name="education[start_year]" class="form-control">
        </div>
        <div class="mb-3">
            <label>End Year</label>
            <input type="date" name="education[end_year]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="education[location]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="education[description]" class="form-control"></textarea>
        </div>

        {{-- Services (Single for now) --}}
        <h4>Service</h4>
        <div class="mb-3">
            <label>Icon Class</label>
            <input type="text" name="service[icon]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="service[name]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Detail</label>
            <textarea name="service[detail]" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="service[status]" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        {{-- Skills (Single for now) --}}
        <h4>Skill</h4>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="skill[name]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Proficiency (1 to 5)</label>
            <input type="number" name="skill[proficiency]" class="form-control" min="1" max="5">
        </div>

        {{-- Project (Single for now) --}}
        <h4>Project</h4>
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="project[title]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="project[description]" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="project[link]" class="form-control">
        </div>
        <div class="mb-3">
            <label>Media</label>
            <input type="file" name="project[media]" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Submit Full Portfolio</button>
    </form>
</div>
@endsection
