<!DOCTYPE html>
<html>
<head>
    <title>Employee Report</title>
    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd; /* Light gray border */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4; /* Light gray background for headers */
            color: #333; /* Dark text color for headers */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternating row colors */
        }

        tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }
    </style>
</head>
<body>
    <h1>Employee Report</h1>
    <table>
        <thead>
            <tr>
                <th>Register No</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Dob</th>
                <!-- Add other headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @php
                // Create a DateTime object from the passed date string
                $date = new DateTime($employee['dob']);

                // Format the date to 'dd-mm-yyyy'
                $new_formate = $date->format('d-m-Y');
            @endphp
                <tr>
                    <td>{{ $employee['register_no'] }}</td>
                    <td>{{ $employee['name'] }}</td>
                    <td>{{ $employee['contact_no'] }}</td>
                    <td>{{ $employee['email'] }}</td>
                    <td>{{ $new_formate }}</td>
                    <!-- Add other fields as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
