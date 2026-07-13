export interface VoucherForm {
    name: string;
    id: string;
    flightNumber: string;
    date: string;
    aircraft: string;
}

export interface CheckResponse {
    exists: boolean;
    message: string;
}

export interface GenerateResponse {
    success: boolean;
    seats: string[];
}