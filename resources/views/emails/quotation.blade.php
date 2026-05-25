<!DOCTYPE html>
<html>
<head>
    <title>New Quotation Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #da200b; border-bottom: 2px solid #da200b; padding-bottom: 10px;">New Quotation Request</h2>
        
        <p>Hello,</p>
        
        <p>A new quotation request has been submitted through the website. Here are the details:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; width: 150px;">Name:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $quotation->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Email:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $quotation->email }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Phone:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $quotation->phone }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Address:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $quotation->address }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Product Name:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $quotation->product_name }}</td>
            </tr>
            @if($quotation->file_path)
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">File:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">Attached</td>
            </tr>
            @endif
        </table>
        
        <p style="margin-top: 20px;">
            <a href="{{ route('quotations.show', $quotation->id) }}" style="background-color: #da200b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">View in Admin Panel</a>
        </p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px;">
            This email was sent from your website.
        </p>
    </div>
</body>
</html>
