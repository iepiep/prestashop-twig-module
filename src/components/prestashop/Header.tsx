
import { cn } from "@/lib/utils";

interface HeaderProps {
  title: string;
  subtitle?: string;
  className?: string;
  type: "bo" | "fo";
}

const Header = ({ title, subtitle, className, type }: HeaderProps) => {
  return (
    <header
      className={cn(
        "mb-8 animate-slide-down",
        type === "bo" ? "text-primary" : "text-foreground",
        className
      )}
    >
      <div className="relative">
        <span className="absolute -top-3 left-0 text-xs font-medium px-2 py-0.5 rounded bg-primary/10 text-primary animate-fade-in">
          {type === "bo" ? "Back Office" : "Front Office"}
        </span>
        <h1 className="text-3xl sm:text-4xl font-bold tracking-tight mt-4">{title}</h1>
      </div>
      {subtitle && (
        <p className="mt-2 text-muted-foreground max-w-3xl">{subtitle}</p>
      )}
    </header>
  );
};

export default Header;
