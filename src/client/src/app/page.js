"use client";

import Counter from "./Counter";
import { useRouter } from "next/navigation";

export default function Home() {
  const router = useRouter();

  return (
    <main className="flex min-h-screen flex-col items-center justify-between p-24">
      <button onClick={() => router.push('/dashboard')}>Dashboard</button>
      <div className="mb-32 grid text-center lg:max-w-5xl lg:w-full lg:mb-0 lg:grid-cols-4 lg:text-left">
        <div className="row">
          <Counter />
        </div>
      </div>
    </main>
  );
}
