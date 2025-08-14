<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Test Rail</h1>
        <div>
            You have received a message from {{$viewModel->senderName}} - {{$viewModel->senderEmail}}.
        </div>
        <br/>
        <h2>
            {{$viewModel->subject}}
        </h2>

        <div>
            {{$viewModel->messageBody}}
        </div>

        <br/>
        <br/>

        <div>
             <a href="mailto:{{$viewModel->senderEmail}}?subject=Re: {{$viewModel->subject}}">{{$viewModel->senderName}}</a>
        </div>

    </body>
</html>
