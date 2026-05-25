<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #2c3e50;
            margin-top: 0;
        }
        .message-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .contact-details {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .cta-button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .checkmark {
            font-size: 48px;
            color: #4caf50;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✉️ Thank You!</h1>
        </div>
        
        <div class="content">
            <div class="checkmark">✓</div>
            
            <h2>Hi {{ $contact->name }},</h2>
            
            <p>Thank you for contacting <strong>Australian Draft</strong>. We have successfully received your message and our team will review it shortly.</p>
            
            <div class="message-box">
                <p style="margin: 0;"><strong>📋 Your Inquiry Summary:</strong></p>
            </div>
            
            <div class="contact-details">
                <div class="detail-row">
                    <span class="label">Name:</span>
                    <span>{{ $contact->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Email:</span>
                    <span>{{ $contact->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Phone:</span>
                    <span>{{ $contact->phone }}</span>
                </div>
                @if($contact->product_name)
                <div class="detail-row">
                    <span class="label">Product:</span>
                    <span>{{ $contact->product_name }}</span>
                </div>
                @endif
                @if($contact->message)
                <div class="detail-row">
                    <span class="label">Message:</span>
                    <div style="margin-top: 5px;">{{ $contact->message }}</div>
                </div>
                @endif>
            </div>
            
            <p><strong>⏱️ What happens next?</strong></p>
            <ul>
                <li>Our team will review your inquiry within 24-48 hours</li>
                <li>We'll get back to you via email or phone</li>
                <li>You'll receive a personalized response to your query</li>
            </ul>
            
            <center>
                <a href="tel:+61423454930" class="cta-button">📞 Call Us: +61-423 454 930</a>
            </center>
            
            <p style="margin-top: 30px; color: #666; font-size: 14px;">
                <em>If you didn't submit this form, please ignore this email or contact us immediately.</em>
            </p>
        </div>
        
        <div class="footer">
            <p style="margin: 5px 0;"><strong>Australian Draft</strong></p>
            <p style="margin: 5px 0;">Phone: +61-423 454 930</p>
            <p style="margin: 5px 0;">Email: <a href="mailto:m.behnam@australiandraft.com.au">m.behnam@australiandraft.com.au</a></p>
            <p style="margin: 15px 0 5px 0; font-size: 12px;">
                © {{ date('Y') }} Australian Draft. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
