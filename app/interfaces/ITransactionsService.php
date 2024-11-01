<?php

namespace interfaces;

use DateTime;
use dtos\TransactionAddRequest;
use dtos\TransactionResponse;
use dtos\TransactionUpdateRequest;

interface ITransactionsService
{
    /**
     * Retrieves all transactions present in the database.
     *
     * @return TransactionResponse[] A list of TransactionResponse objects.
     */
    public function getTransactions(): array;

    /**
     * Retrieves a specific transaction by its ID.
     *
     * @param string|null $transactionId The ID of the category to retrieve.
     * @return TransactionResponse|null A CategoryResponse with information about the selected category, or null if not found.
     */
    public function getTransactionByTransactionId(?string $transactionId): ?TransactionResponse;

    /**
     * Adds transaction to database
     *
     * @param TransactionAddRequest|null $request Transaction to add
     * @return TransactionResponse The same details but with generated Guid
     */
    public function addTransaction(?TransactionAddRequest $request) : TransactionResponse;

    /**
     * Updates information about transaction
     *
     * @param TransactionUpdateRequest|null $request Transaction to update
     * @return TransactionResponse CategoryResponse with updated information about category
     */
    public function updateTransaction(?TransactionUpdateRequest $request) : TransactionResponse;

    /**
     * Removes transaction from database
     *
     * @param string|null $guid Id of transaction to remove
     * @return bool True if success, false if error has occurred
     */
    public function deleteTransaction(?string $guid) : bool;

    /**
     * Retrives all transactions that match filter parameters
     *
     * @param string $filterBy
     * @param string|null $filterString
     * @return array|TransactionResponse A list of filtered TransactionResponses
     */
    public function getFilteredTransactions(string $filterBy, ?string $filterString) : array|TransactionResponse;

    /**
     * Retrives all transaction made between two dates
     *
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @return array A list of selected TransactionResponses
     */
    public function getTransactionBetweenTwoDates(?DateTime $startDate, ?DateTime $endDate) : array;

    public function getFirstTransaction() : TransactionResponse;
    /**
     * Retrives all categories names of present transactions
     *
     * @return array A list of names of categories
     */
    public function getCategoryNamesOfTransactions() : array;
}