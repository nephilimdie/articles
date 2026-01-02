<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

enum GrpcStatus: int
{
    case OK = 0;
    case CANCELLED = 1;
    case UNKNOWN = 2;
    case INVALID_ARGUMENT = 3;
    case DEADLINE_EXCEEDED = 4;
    case NOT_FOUND = 5;
    case ALREADY_EXISTS = 6;
    case PERMISSION_DENIED = 7;
    case RESOURCE_EXHAUSTED = 8;
    case FAILED_PRECONDITION = 9;
    case ABORTED = 10;
    case OUT_OF_RANGE = 11;
    case UNIMPLEMENTED = 12;
    case INTERNAL = 13;
    case UNAVAILABLE = 14;
    case DATA_LOSS = 15;
    case UNAUTHENTICATED = 16;
}

