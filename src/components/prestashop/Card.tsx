
import { ReactNode } from "react";
import { cn } from "@/lib/utils";

interface CardProps {
  title?: string;
  children: ReactNode;
  className?: string;
  icon?: ReactNode;
  footer?: ReactNode;
}

const Card = ({ title, children, className, icon, footer }: CardProps) => {
  return (
    <div
      className={cn(
        "glass rounded-lg overflow-hidden animate-fade-in",
        className
      )}
    >
      {(title || icon) && (
        <div className="p-4 sm:p-6 border-b flex items-center gap-3">
          {icon && <div className="text-primary">{icon}</div>}
          {title && <h3 className="text-lg font-medium">{title}</h3>}
        </div>
      )}
      <div className="p-4 sm:p-6">{children}</div>
      {footer && <div className="p-4 sm:p-6 border-t bg-secondary/50">{footer}</div>}
    </div>
  );
};

export default Card;
