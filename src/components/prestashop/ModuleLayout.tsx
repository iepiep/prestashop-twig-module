
import { ReactNode } from "react";
import { cn } from "@/lib/utils";

interface ModuleLayoutProps {
  children: ReactNode;
  className?: string;
  type: "bo" | "fo";
}

const ModuleLayout = ({ children, className, type }: ModuleLayoutProps) => {
  return (
    <div
      className={cn(
        "w-full min-h-screen",
        type === "bo" ? "bg-secondary/50" : "bg-background",
        "animate-fade-in",
        className
      )}
    >
      <div className="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        {children}
      </div>
    </div>
  );
};

export default ModuleLayout;
