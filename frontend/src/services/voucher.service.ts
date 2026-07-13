import api from '../api/axios.ts';

import type { VoucherForm, CheckResponse, GenerateResponse } from '../types/voucher.ts';

export const checkVoucher = async(flightNumber: string, date: string) => {
    const response = await api.post<CheckResponse>(
        '/check',
        {
            flightNumber,
            date
        }
    )

    return response.data;
}

export const generateVoucher = async(data: VoucherForm,) => {
    console.log("Generating voucher with data:", data); // Debugging line
    const response = await api.post<GenerateResponse>(
        '/generate',
        data
    )

    return response.data;
}
