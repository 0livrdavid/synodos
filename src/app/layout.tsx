import { ReactNode } from "react"

export const metadata = {
     title: 'Synodos',
     description: 'Synodos',
}

export default function RootLayout({
     children,
}: {
     children: ReactNode
}) {
     return (
          <html lang="pt-br">
               <body>{children}</body>
          </html>
     )
}
