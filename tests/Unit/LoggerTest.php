<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Logger;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Throwable;
use Exception;

class LoggerTest extends TestCase
{
    public function test_dispatch_logs_message_without_exception(): void
    {
        Log::shouldReceive('channel')
            ->once()
            ->with('stack')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->with('Test message', \Mockery::on(function ($context) {
                return isset($context['env']);
            }));

        Logger::dispatch('info', 'Test message');
    }

    public function test_dispatch_logs_message_with_exception(): void
    {
        Log::shouldReceive('channel')
            ->once()
            ->with('stack')
            ->andReturnSelf();

        Log::shouldReceive('error')
            ->once()
            ->with('Test error', \Mockery::on(function ($context) {
                return isset($context['Message'], $context['File'], $context['Stack Trace'], $context['env']);
            }));

        $exception = new Exception('Exception message');
        Logger::dispatch('error', 'Test error', [], [], $exception);
    }

    public function test_emergency_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('emergency')->once()->with('Emergency!', \Mockery::any());

        Logger::emergency('Emergency!');
    }

    public function test_alert_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('alert')->once()->with('Alert!', \Mockery::any());

        Logger::alert('Alert!');
    }

    public function test_critical_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('critical')->once()->with('Critical!', \Mockery::any());

        Logger::critical('Critical!');
    }

    public function test_error_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('error')->once()->with('Error!', \Mockery::any());

        Logger::error('Error!');
    }

    public function test_warning_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('warning')->once()->with('Warning!', \Mockery::any());

        Logger::warning('Warning!');
    }

    public function test_notice_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('notice')->once()->with('Notice!', \Mockery::any());

        Logger::notice('Notice!');
    }

    public function test_info_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('info')->once()->with('Info!', \Mockery::any());

        Logger::info('Info!');
    }

    public function test_debug_method(): void
    {
        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('debug')->once()->with('Debug!', \Mockery::any());

        Logger::debug('Debug!');
    }

    public function test_throw_exception_and_log(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Test exception');

        Log::shouldReceive('channel')->once()->with('stack')->andReturnSelf();
        Log::shouldReceive('error')->once()->with('Test exception', \Mockery::any());

        Logger::throwExceptionAndLog('Test exception');
    }
}