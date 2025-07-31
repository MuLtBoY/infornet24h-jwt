<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

trait ApiResponseTrait
{
    protected $responseCode;
    protected $errorMessages;

    public function setStartValues()
    {
        $this->responseCode = $this->responseCode ?? 200;
        $this->errorMessages = $this->errorMessages ?? [];
    }

    public function resolveResponse(array|object $entity, string $customMessage): JsonResponse
    {
        $this->setStartValues();
        $this->customMessage = $customMessage;
        if($this->responseCode != 200) {
            return $this->error();
        }

        return $this->success($entity);
    }

    private function success(array|object $data = []): JsonResponse
    {
        $responseMerged = $this->additionalResponseData($data);

        return response()->json($responseMerged, 200);
    }

    private function additionalResponseData(array|object $data): array
    {
        $response = [
            'success' => true,
            'message' => ucfirst($this->customMessage) . ' concluído com sucesso.',
        ];

        if (is_array($data)) {
            $response = array_merge($response, $data);
        }

        if ($data instanceof \JsonSerializable) {
            $response = array_merge($response, $data->jsonSerialize());
        }

        if ($data instanceof \Illuminate\Contracts\Support\Arrayable) {
            $response = array_merge($response, $data->toArray());
        }

        return $response;
    }

    private function error(): JsonResponse
    {
        $message = (substr((string) $this->responseCode, 0, 1) === '4') ? 'Falha ao ' : 'Erro interno ao ';
        return response()->json([
            'success' => false,
            'code' => $this->responseCode,
            'message' => $message . $this->customMessage,
            'errors' => $this->errorMessages,
        ], $this->responseCode);
    }

    public function resolveException(Throwable $e) :void
    {
        $this->setStartValues();

        $this->responseCode = $this->responseCode != 200 ? $this->responseCode : 500;
        $this->errorMessages = [$e->getMessage()];

        if($e instanceof ValidationException) {
            $this->errorMessages = collect($e->validator->errors()->all());
            $this->responseCode = 422;
        }

        Log::error($e->getMessage() . ": " . $e->getTraceAsString());
    }
}