import { useState } from "react";
import { AxiosError } from "axios";

import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

import { Button } from "@/components/ui/button";

import { Alert, AlertDescription } from "@/components/ui/alert";

import { Calendar } from "@/components/ui/calendar"

import type { VoucherForm as VoucherFormType } from "@/types/voucher";

import {
    checkVoucher,
    generateVoucher,
} from "@/services/voucher.service";
import { Popover, PopoverContent, PopoverTrigger } from "./ui/popover";
import { format } from "date-fns/format";
import { CalendarIcon } from "lucide-react";
import { ButtonGroup } from "./ui/button-group";
import { Field, FieldLabel } from "./ui/field";


export default function VoucherForm() {

    const [form, setForm] = useState<VoucherFormType>({
        name: "",
        id: "",
        flightNumber: "",
        date: "",
        aircraft: "",
    });

    const [date, setDate] = useState<Date | undefined>(
        new Date()
    );

    const [seats, setSeats] = useState<string[]>([]);

    const [error, setError] = useState("");

    const [loading, setLoading] = useState(false);

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement>
    ) => {

        setForm({
            ...form,
            [e.target.name]: e.target.value,
        });

    };

    const handleAircraftChange = (
        value: string | null
    ) => {

        setForm({
            ...form,
            aircraft: value ?? "",
        });

    };

    const handleSubmit = async (
        e: React.FormEvent
    ) => {

        e.preventDefault();

        setError("");
        setSeats([]);

        try {
            setLoading(true);

            const payload = {
                ...form,
                date: date
                    ? format(date, "yyyy-MM-dd")
                    : "",
            };

            const check = await checkVoucher(
                payload.flightNumber,
                payload.date
            );

            if (check.exists) {
                setError(
                    "Voucher already exists for this flight."
                );
                return;
            }

            const result = await generateVoucher(payload);

            setSeats(result.seats);

        } catch (err: unknown) {
            const error = err as AxiosError<{ errors?: Record<string, string[]>; message?: string }>;

            if (error.response?.data?.errors) {
                const errors =
                    Object.values(
                        error.response.data.errors
                    ).flat();

                setError(
                    errors.join(", ")
                );
            } else {
                setError(
                    error.response?.data?.message ??
                    "Something went wrong."
                );
            }

        } finally {
            setLoading(false);
        }
    };

    return (
        <Card className="max-w-xl mx-auto mt-10">

            <CardHeader>
                <CardTitle>
                    Airline Voucher Seat Assignment
                </CardTitle>
            </CardHeader>

            <CardContent>

                <form
                    onSubmit={handleSubmit}
                    className="space-y-4"
                >
                    <div className="space-y-2">
                        <Label>
                            Crew Name
                        </Label>

                        <Input
                            name="name"
                            value={form.name}
                            onChange={handleChange}
                            placeholder="Sarah"
                        />
                    </div>

                    <div className="space-y-2">
                        <Label>
                            Crew ID
                        </Label>

                        <Input
                            name="id"
                            value={form.id}
                            onChange={handleChange}
                            placeholder="98123"
                        />
                    </div>

                    <div className="space-y-2">
                        <Label>
                            Flight Number
                        </Label>

                        <Input
                            name="flightNumber"
                            value={form.flightNumber}
                            onChange={handleChange}
                            placeholder="GA102"
                        />
                    </div>

                    <div className="space-y-2">
                        <Field>
                            <FieldLabel htmlFor="flight-date">
                                Flight Date
                            </FieldLabel>

                            <ButtonGroup>

                                <Popover>

                                    <PopoverTrigger
                                        render={
                                            <Button
                                                type="button"
                                                variant="outline"
                                                size="icon"
                                            />
                                        }
                                    >
                                        <CalendarIcon />
                                    </PopoverTrigger>


                                    <PopoverContent
                                        className="w-auto p-0"
                                        align="start"
                                    >
                                        <Calendar
                                            mode="single"
                                            selected={date}
                                            onSelect={setDate}
                                        />
                                    </PopoverContent>

                                </Popover>


                                <Input
                                    id="flight-date"
                                    value={
                                        date
                                            ? format(date, "dd-MM-yyyy")
                                            : ""
                                    }
                                    placeholder="DD-MM-YYYY"
                                    readOnly
                                />

                            </ButtonGroup>

                        </Field>
                       
                    </div>

                    <div className="space-y-2">
                        <Label>
                            Aircraft Type
                        </Label>


                        <Select
                            value={form.aircraft}
                            onValueChange={
                                handleAircraftChange
                            }
                        >

                            <SelectTrigger>
                                <SelectValue placeholder="Select aircraft" />
                            </SelectTrigger>


                            <SelectContent>

                                <SelectItem value="ATR">
                                    ATR
                                </SelectItem>


                                <SelectItem value="Airbus 320">
                                    Airbus 320
                                </SelectItem>


                                <SelectItem value="Boeing 737 Max">
                                    Boeing 737 Max
                                </SelectItem>

                            </SelectContent>

                        </Select>
                    </div>

                    {
                        error && (
                            <Alert variant="destructive">
                                <AlertDescription>
                                    {error}
                                </AlertDescription>
                            </Alert>
                        )
                    }

                    <Button
                        type="submit"
                        disabled={loading}
                        className="w-full"
                    >

                        {
                            loading
                            ? "Generating..."
                            : "Generate Vouchers"
                        }

                    </Button>
                </form>

                {
                    seats.length > 0 && (

                        <div className="mt-6">

                            <h3 className="font-semibold mb-3">
                                Generated Seats
                            </h3>

                            <div className="grid grid-cols-3 gap-3">
                                {
                                    seats.map((seat) => (

                                        <div
                                            key={seat}
                                            className="border rounded-lg p-4 text-center font-bold"
                                        >
                                            {seat}
                                        </div>

                                    ))
                                }
                            </div>
                        </div>
                    )
                }
            </CardContent>
        </Card>
    );
}