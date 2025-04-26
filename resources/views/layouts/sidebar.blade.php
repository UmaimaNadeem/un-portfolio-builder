<div class="sidebar" id="sidebar">
    <h5 class="text-center text-white mb-4">Portfolio Builder</h5>
    <ul class="list-unstyled">
        <li><a href="#" class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        
        <li>
            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#portfolioMenu">
                <i class="fa fa-briefcase"></i> Portfolio Management <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="collapse" id="portfolioMenu">
            <li><a href="{{ route('personal_info.index') }}">Personal Information</a></li>
            <li><a href="{{ route('education.index') }}">Education</a></li>               
            <li><a href="{{ route('skills.index') }}">Skills</a></li>               
            <li><a href="{{ route('work_experiences.index') }}">Work Experiences</a></li>               
            <li><a href="{{ route('projects.index') }}">Projects</a></li>               
            </ul>
        </li>
        
        <li>
            <a href="{{ route('portfolio.index') }}">
                <i class="fa fa-cogs"></i> My Portfolio
            </a>
        </li>

        <li>
            <a href="{{ route('armodels.index') }}">
                <i class="fa fa-cogs"></i> 3D Models
            </a>
        </li>
        
        <li><a href="#"><i class="fa fa-wrench"></i> Skills</a></li>
        
        <li><a href="#"><i class="fa fa-users"></i> Clients</a></li>
        
        <li>
            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#themesMenu">
                <i class="fa fa-paint-brush"></i> Themes <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="collapse" id="themesMenu">
                <li><a href="#">Manage Themes</a></li>
                <li><a href="#">Create New Theme</a></li>
            </ul>
        </li>

        <li><a href="#"><i class="fa fa-cogs"></i> Settings</a></li>
    </ul>
</div>
