<table>
    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Personal Email</th>
        <th>Corporate Email</th>
        <th>Email Status</th>
        <th>Current Job Title</th>
        <th>Current Employer</th>
        <th>Employer Website</th>
        <th>Location</th>
        <th>Sales Nav URL</th>
        <th>Top Skill 1</th>
        <th>Top Skill 2</th>
        <th>Top Skill 3</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
        <?php
            // Name Splitter
            $candidate_name = explode(" ", $lead->full_name);

            switch($lead->status){
                case 0:
                    $EmailStatus = "Pending";
                    break;
                case 1:
                    $EmailStatus = "Unknown";
                    break;
                case 2:
                    $EmailStatus = "Valid";
                    break;
            }
            if(strlen($lead->corporate_email) < 2){$EmailStatus = "";}
        ?>
        <tr>
            <td>{{ $candidate_name[0] }}</td>
            <td>{{ end($candidate_name) }}</td>
            <td>{{ $lead->personal_email }}</td>
            <td>{{ $lead->corporate_email }}</td>
            <td>{{ $EmailStatus }}</td>
            <td>{{ $lead->current_job_title }}</td>
            <td>{{ $lead->current_employer }}</td>
            <td>{{ $lead->current_employer_website }}</td>
            <td>{{ $lead->location }}</td>
            <td>{{ $lead->sales_link }}</td>
            <td>{{ $lead->top_skill_1 }}</td>
            <td>{{ $lead->top_skill_2 }}</td>
            <td>{{ $lead->top_skill_3 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
