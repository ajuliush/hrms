<style>
    html,
    body,
    div {
        font-family: nikosh;
        font-size: 16px;
        line-height: 200%;
    }
</style>
@if ($user->experience_letter_id)

<div>
    <div class="header-logo">
        <div>
            <img style="max-height: 50px;"  src="{{asset('uploads/logos/predictionit.png')}}" />
        </div>
    </div> <br>
    <?php
$date = date('j F, Y');

?>

    Date: {{ $date }} <br><br>
    Name: {{ $user->first_name . ' ' . $user->last_name }} <br>
    Designation: {{ $user->userdesignation->designation_name ?? null }} <br>
    Department: {{ $user->userdepartment->department_name ?? null }} <br><br>
    <span style="font-weight:bold;"> Subject: {{$user->experienceLetter->subject ?? '' }}</span><br><br>

    Dear {{ $user->first_name . ' ' . $user->last_name }} ,<br><br>


    <!-- this can be removed -->
    This is to state that <b>{{ $user->first_name }} {{ $user->last_name }}</b> has been employed at
    {{ Auth::user()->first_name }} {{ Auth::user()->last_named }}
    from <b>{{ $user->joining_date }}</b> to <b>{{ now()->format('D-m-y') }}</b> as a
    <b>{{ $user->userdesignation->designation_name }}</b> with development as his area of expertise.<br />

    <br /> {!! $user->experienceLetter->description !!}<br />

    <div align="left">
        <!-- this can be changed to "left" if preferred-->
        Best Regards <br />
        <img src="{{ asset($user->experienceLetter->signature ?? '') }}" alt="" height="20px" width="" 150px>
        <br /> {{ $user->experienceLetter->experienceSignatory->first_name }}
        {{ $user->experienceLetter->experienceSignatory->last_name }}
        <br />
        {{ Auth::user()->first_name }} {{ Auth::user()->last_named }}<br />


    </div>

</div>
@else
<h2>okkk</h2>
@endif
